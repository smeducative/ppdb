import { Head, router, usePage } from "@inertiajs/react";
import { format } from "date-fns";
import { InertiaPagination as Pagination } from "@/components/inertia-pagination";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import {
	Table,
	TableBody,
	TableCell,
	TableHead,
	TableHeader,
	TableRow,
} from "@/components/ui/table";

interface User {
	id: number;
	name: string;
}

interface Peserta {
	id: string;
	no_pendaftaran: string;
	nama_lengkap: string;
}

interface Kwitansi {
	id: number;
	jenis_pembayaran: string;
	nominal: number;
	created_at: string;
	deleted_at: string | null;
	penerima: User;
	deleted_by: User | null;
	peserta_ppdb: Peserta;
}

interface PaginationData {
	data: Kwitansi[];
	links: any[];
	current_page: number;
	last_page: number;
	total: number;
}

interface JenisPembayaran {
	[key: string]: {
		count: number;
		total: number;
	};
}

interface Props {
	kwitansiesHistory: PaginationData;
	danaKelola: number;
	jenisPembayaran: JenisPembayaran;
	tahun: number;
	years: number[];
}

export default function Rekap({
	kwitansiesHistory,
	danaKelola,
	jenisPembayaran,
	tahun,
	years,
}: Props) {
	const { csrf_token } = usePage<any>().props;
	const handleYearChange = (value: string) => {
		router.get(
			route("ppdb.kwitansi.rekap"),
			{ tahun: value },
			{ preserveState: true },
		);
	};

	const formatCurrency = (amount: number) => {
		return new Intl.NumberFormat("id-ID", {
			style: "currency",
			currency: "IDR",
			minimumFractionDigits: 0,
		}).format(amount);
	};

	return (
		<>
			<Head title="Rekap Kwitansi" />

			<div className="space-y-6">
				<div className="w-full sm:w-1/4">
					<Select value={String(tahun)} onValueChange={handleYearChange}>
						<SelectTrigger>
							<SelectValue placeholder="Pilih Tahun" />
						</SelectTrigger>
						<SelectContent>
							{years.map((y) => (
								<SelectItem key={y} value={String(y)}>
									{y}
								</SelectItem>
							))}
						</SelectContent>
					</Select>
				</div>

				<div className="grid grid-cols-1 md:grid-cols-2 gap-4">
					<Card className="bg-orange-500/10 border-orange-500/20">
						<CardHeader>
							<CardTitle className="text-orange-600 dark:text-orange-400 text-lg">
								Dana Masuk
							</CardTitle>
						</CardHeader>
						<CardContent>
							<div className="text-3xl font-bold text-orange-700 dark:text-orange-300">
								{formatCurrency(danaKelola)}
							</div>
						</CardContent>
					</Card>
					<Card className="bg-blue-500/10 border-blue-500/20">
						<CardHeader>
							<CardTitle className="text-blue-600 dark:text-blue-400 text-lg">
								Jumlah Kwitansi
							</CardTitle>
						</CardHeader>
						<CardContent>
							{/* Note: This is count of not-deleted items */}
							<div className="text-3xl font-bold text-blue-700 dark:text-blue-300">
								{Object.values(jenisPembayaran).reduce(
									(sum, item) => sum + item.count,
									0,
								)}
							</div>
						</CardContent>
					</Card>
				</div>

				<div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
					<Card>
						<CardHeader className="flex flex-row items-center justify-between">
							<CardTitle>Jenis Dana Kelola</CardTitle>
							<Button asChild variant="outline" size="sm">
								<form
									action={`${route("ppdb.rekap.kwitansi-dana")}?tahun=${tahun}`}
									method="post"
									target="_blank"
								>
									<input type="hidden" name="_token" value={csrf_token} />
									<button type="submit">Export .xlsx</button>
								</form>
							</Button>
						</CardHeader>
						<CardContent>
							<Table>
								<TableHeader>
									<TableRow>
										<TableHead>Jenis Pembayaran</TableHead>
										<TableHead>Total Dana</TableHead>
										<TableHead>Jumlah Kwitansi</TableHead>
									</TableRow>
								</TableHeader>
								<TableBody>
									{Object.entries(jenisPembayaran).length > 0 ? (
										Object.entries(jenisPembayaran).map(([jenis, data]) => (
											<TableRow key={jenis}>
												<TableCell>{jenis}</TableCell>
												<TableCell>{formatCurrency(data.total)}</TableCell>
												<TableCell>{data.count}</TableCell>
											</TableRow>
										))
									) : (
										<TableRow>
											<TableCell colSpan={3} className="text-center">
												Tidak ada data
											</TableCell>
										</TableRow>
									)}
								</TableBody>
							</Table>
						</CardContent>
					</Card>

					<Card>
						<CardHeader className="flex flex-row items-center justify-between">
							<CardTitle>Riwayat Kwitansi Terakhir</CardTitle>
							<Button asChild variant="outline" size="sm">
								<form
									action={`${route("ppdb.rekap.kwitansi-riwayat")}?tahun=${tahun}`}
									method="post"
									target="_blank"
								>
									<input type="hidden" name="_token" value={csrf_token} />
									<button type="submit">Export .xlsx</button>
								</form>
							</Button>
						</CardHeader>
						<CardContent>
							<Table>
								<TableHeader>
									<TableRow>
										<TableHead>No. Peserta</TableHead>
										<TableHead>Nama</TableHead>
										<TableHead>Jenis Pembayaran</TableHead>
										<TableHead>Jumlah</TableHead>
										<TableHead>Tanggal</TableHead>
										<TableHead>Aksi</TableHead>
									</TableRow>
								</TableHeader>
								<TableBody>
									{kwitansiesHistory.data.length > 0 ? (
										kwitansiesHistory.data.map((k) => (
											<TableRow
												key={k.id}
												className={
													k.deleted_at ? "bg-red-500/10 dark:bg-red-900/20" : ""
												}
											>
												<TableCell>{k.peserta_ppdb?.no_pendaftaran}</TableCell>
												<TableCell>{k.peserta_ppdb?.nama_lengkap}</TableCell>
												<TableCell>{k.jenis_pembayaran}</TableCell>
												<TableCell>{formatCurrency(k.nominal)}</TableCell>
												<TableCell>
													{format(new Date(k.created_at), "dd/MM/yy HH:mm")}
												</TableCell>
												<TableCell>
													{!k.deleted_at ? (
														<Button asChild size="sm" variant="secondary">
															<form
																action={route("ppdb.cetak.kwitansi.single", {
																	uuid: k.peserta_ppdb.id,
																	id: k.id,
																})}
																method="post"
																target="_blank"
															>
																<input
																	type="hidden"
																	name="_token"
																	value={csrf_token}
																/>
																<button type="submit">Cetak</button>
															</form>
														</Button>
													) : (
														<span className="text-destructive text-xs">
															dihapus oleh {k.deleted_by?.name}
														</span>
													)}
												</TableCell>
											</TableRow>
										))
									) : (
										<TableRow>
											<TableCell colSpan={6} className="text-center">
												Belum ada kwitansi
											</TableCell>
										</TableRow>
									)}
								</TableBody>
							</Table>
							<div className="mt-4">
								<Pagination links={kwitansiesHistory.links} />
							</div>
						</CardContent>
					</Card>
				</div>
			</div>
		</>
	);
}
}

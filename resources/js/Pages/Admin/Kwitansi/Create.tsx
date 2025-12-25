import { AlertMessages } from "@/components/alert-messages";
import {
	AlertDialog,
	AlertDialogAction,
	AlertDialogCancel,
	AlertDialogContent,
	AlertDialogDescription,
	AlertDialogFooter,
	AlertDialogHeader,
	AlertDialogTitle,
	AlertDialogTrigger,
} from "@/components/ui/alert-dialog";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Separator } from "@/components/ui/separator";
import {
	Table,
	TableBody,
	TableCell,
	TableHead,
	TableHeader,
	TableRow,
} from "@/components/ui/table";
import { Head, router, useForm, usePage } from "@inertiajs/react";
import { format } from "date-fns";

interface User {
	id: number;
	name: string;
}

interface Jurusan {
	id: number;
	nama: string;
	abbreviation: string;
}

interface Kwitansi {
	id: number;
	jenis_pembayaran: string;
	nominal: number;
	created_at: string;
	deleted_at: string | null;
	penerima: User;
	deleted_by: User | null;
}

interface Peserta {
	id: string;
	no_pendaftaran: string;
	nama_lengkap: string;
	jurusan: Jurusan;
	kwitansi: Kwitansi[];
}

interface Props {
	peserta: Peserta;
}

export default function Create({ peserta }: Props) {
	const { data, setData, post, processing, errors, reset } = useForm({
		jenis_pembayaran: "",
		nominal: "",
	});

	const { flash, csrf_token } = usePage<any>().props;

	const submit = (e: React.FormEvent) => {
		e.preventDefault();
		post(route("ppdb.kwitansi.tambah", { uuid: peserta.id }), {
			onSuccess: () => reset(),
		});
	};

	const handleDelete = (id: number) => {
		router.delete(route("ppdb.kwitansi.hapus", { id }));
	};

	const formatCurrency = (amount: number) => {
		return new Intl.NumberFormat("id-ID", {
			style: "currency",
			currency: "IDR",
			minimumFractionDigits: 0,
		}).format(amount);
	};

	const totalTerbayar = peserta.kwitansi
		.filter((k) => !k.deleted_at)
		.reduce((sum, k) => sum + k.nominal, 0);

	return (
		<>
			<Head title="Tambah Kwitansi" />

			<div className="space-y-6 mx-auto max-w-7xl">
				<AlertMessages flash={flash} />

				<Card className="lg:min-w-3xl">
					<CardHeader>
						<CardTitle>Kwitansi Peserta</CardTitle>
					</CardHeader>
					<CardContent>
						<form onSubmit={submit} className="space-y-4">
							<div className="gap-4 grid grid-cols-1 md:grid-cols-2">
								<div className="space-y-2">
									<Label>No. Pendaftaran</Label>
									<div className="font-bold text-lg">
										{peserta.no_pendaftaran}
									</div>
								</div>
								<div className="space-y-2">
									<Label>Nama Lengkap</Label>
									<div className="font-medium">{peserta.nama_lengkap}</div>
								</div>
							</div>

							<Separator />

							<div className="gap-4 grid grid-cols-1 md:grid-cols-2">
								<div className="space-y-2">
									<Label htmlFor="jenis_pembayaran">Jenis Pembayaran</Label>
									<Input
										id="jenis_pembayaran"
										value={data.jenis_pembayaran}
										onChange={(e) =>
											setData("jenis_pembayaran", e.target.value)
										}
										placeholder="Contoh: Daftar Ulang, Seragam"
										required
									/>
									{errors.jenis_pembayaran && (
										<span className="text-destructive text-sm">
											{errors.jenis_pembayaran}
										</span>
									)}
								</div>
								<div className="space-y-2">
									<Label htmlFor="nominal">Jumlah (Rp)</Label>
									<Input
										id="nominal"
										type="number"
										min="1"
										value={data.nominal}
										onChange={(e) => setData("nominal", e.target.value)}
										placeholder="Contoh: 150000"
										required
									/>
									<p className="text-muted-foreground text-xs">
										*Tanpa titik maupun koma
									</p>
									{errors.nominal && (
										<span className="text-destructive text-sm">
											{errors.nominal}
										</span>
									)}
								</div>
							</div>

							<Button type="submit" disabled={processing}>
								{processing ? "Menyimpan..." : "Tambah Kwitansi"}
							</Button>
						</form>
					</CardContent>
				</Card>

				<Card className="lg:min-w-3xl">
					<CardHeader className="flex flex-row justify-between items-center">
						<CardTitle>Riwayat Pembayaran</CardTitle>
						<div className="flex gap-2">
							<Button
								variant="outline"
								className="hover:bg-background cursor-default"
							>
								Total: {formatCurrency(totalTerbayar)}
							</Button>
							<Button asChild>
								<form
									action={route("ppdb.cetak.kwitansi", { uuid: peserta.id })}
									method="post"
									target="_blank"
								>
									<input type="hidden" name="_token" value={csrf_token} />
									<button type="submit">Cetak Semua</button>
								</form>
							</Button>
						</div>
					</CardHeader>
					<CardContent>
						{peserta.kwitansi.length > 0 ? (
							<Table>
								<TableHeader>
									<TableRow>
										<TableHead>Jenis Pembayaran</TableHead>
										<TableHead>Jumlah</TableHead>
										<TableHead>Pada Tanggal</TableHead>
										<TableHead>Penerima</TableHead>
										<TableHead>Aksi</TableHead>
									</TableRow>
								</TableHeader>
								<TableBody>
									{peserta.kwitansi.map((k) => (
										<TableRow
											key={k.id}
											className={
												k.deleted_at ? "bg-red-500/10 dark:bg-red-900/20" : ""
											}
										>
											<TableCell>{k.jenis_pembayaran}</TableCell>
											<TableCell>{formatCurrency(k.nominal)}</TableCell>
											<TableCell>
												{format(new Date(k.created_at), "dd MMMM yyyy HH:mm")}
											</TableCell>
											<TableCell>
												{k.deleted_at ? (
													<div className="text-destructive">
														<strong>Dihapus</strong>
														<br />
														<span className="text-xs">
															{k.deleted_by?.name}
														</span>
													</div>
												) : (
													<div className="text-green-600 dark:text-green-400">
														<strong>Diterima</strong>
														<br />
														<span className="text-xs">{k.penerima?.name}</span>
													</div>
												)}
											</TableCell>
											<TableCell className="flex gap-2">
												{!k.deleted_at && (
													<>
														<Button asChild size="sm" variant="secondary">
															<form
																action={route("ppdb.cetak.kwitansi.single", {
																	uuid: peserta.id,
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

														<AlertDialog>
															<AlertDialogTrigger asChild>
																<Button size="sm" variant="destructive">
																	Hapus
																</Button>
															</AlertDialogTrigger>
															<AlertDialogContent>
																<AlertDialogHeader>
																	<AlertDialogTitle>
																		Hapus Kwitansi?
																	</AlertDialogTitle>
																	<AlertDialogDescription>
																		Transaksi ini akan ditandai sebagai dihapus.
																	</AlertDialogDescription>
																</AlertDialogHeader>
																<AlertDialogFooter>
																	<AlertDialogCancel>Batal</AlertDialogCancel>
																	<AlertDialogAction
																		onClick={() => handleDelete(k.id)}
																		className="bg-red-600 hover:bg-red-700"
																	>
																		Hapus
																	</AlertDialogAction>
																</AlertDialogFooter>
															</AlertDialogContent>
														</AlertDialog>
													</>
												)}
											</TableCell>
										</TableRow>
									))}
								</TableBody>
							</Table>
						) : (
							<div className="py-4 text-muted-foreground text-center">
								Belum ada kwitansi.
							</div>
						)}
					</CardContent>
				</Card>
			</div>
		</>
	);
}

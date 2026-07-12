import { TableHeaderLabel } from "@/components/data-table";
import { InertiaPagination as Pagination } from "@/components/inertia-pagination";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Input } from "@/components/ui/input";
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
import { cn } from "@/lib/utils";
import { useDebounce } from "@/hooks/use-debounce";
import { usePrintRoute } from "@/hooks/use-print-route";
import { Head, router } from "@inertiajs/react";
import { format } from "date-fns";
import {
	Banknote,
	CalendarClock,
	ClipboardList,
	FileCheck,
	FileText,
	Hash,
	Printer,
	ReceiptText,
	Search,
	Settings2,
	Trash2,
	User,
	Wallet,
} from "lucide-react";
import { useEffect, useState } from "react";

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
	allJenisPembayaran: string[];
	search: string | null;
	jenisPembayaranFilter: string | null;
	statusFilter: string | null;
}

const JENIS_PEMBAYARAN_ICONS: Record<
	string,
	React.ComponentType<{ className?: string }>
> = {
	"Daftar Ulang": ReceiptText,
	SPP: Banknote,
	"Seragam": FileCheck,
};

const JENIS_PEMBAYARAN_COLORS: Record<string, string> = {
	"Daftar Ulang": "bg-amber-500",
	SPP: "bg-sky-500",
	"Seragam": "bg-emerald-500",
};

const JENIS_PEMBAYARAN_FALLBACK_COLORS = [
	"bg-violet-500",
	"bg-rose-500",
	"bg-cyan-500",
	"bg-orange-500",
	"bg-indigo-500",
	"bg-pink-500",
];

export default function Rekap({
	kwitansiesHistory,
	danaKelola,
	jenisPembayaran,
	tahun,
	years,
	allJenisPembayaran,
	search: initialSearch,
	jenisPembayaranFilter,
	statusFilter,
}: Props) {
	const { printFromRoute, printingDocumentId, isPrinting, PrintFrame } =
		usePrintRoute();

	const [search, setSearch] = useState(initialSearch || "");
	const debouncedSearch = useDebounce(search, 500);

	const navigateWithParams = (params: Record<string, string>) => {
		router.get(route("ppdb.rekap.kwitansi"), params, {
			preserveState: true,
			replace: true,
		});
	};

	useEffect(() => {
		const params: Record<string, string> = { tahun: String(tahun) };
		if (debouncedSearch) params.search = debouncedSearch;
		if (jenisPembayaranFilter) params.jenis_pembayaran = jenisPembayaranFilter;
		if (statusFilter) params.status = statusFilter;

		navigateWithParams(params);
	}, [debouncedSearch]);

	const handleYearChange = (value: string) => {
		const params: Record<string, string> = { tahun: value };
		if (search) params.search = search;
		if (jenisPembayaranFilter) params.jenis_pembayaran = jenisPembayaranFilter;
		if (statusFilter) params.status = statusFilter;

		navigateWithParams(params);
	};

	const handleJenisPembayaranChange = (value: string) => {
		const params: Record<string, string> = { tahun: String(tahun) };
		if (search) params.search = search;
		if (value !== "all") params.jenis_pembayaran = value;
		if (statusFilter) params.status = statusFilter;

		navigateWithParams(params);
	};

	const handleStatusChange = (value: string) => {
		const params: Record<string, string> = { tahun: String(tahun) };
		if (search) params.search = search;
		if (jenisPembayaranFilter) params.jenis_pembayaran = jenisPembayaranFilter;
		if (value !== "all") params.status = value;

		navigateWithParams(params);
	};

	const formatCurrency = (amount: number) => {
		return new Intl.NumberFormat("id-ID", {
			style: "currency",
			currency: "IDR",
			minimumFractionDigits: 0,
		}).format(amount);
	};

	const totalKwitansi = Object.values(jenisPembayaran).reduce(
		(sum, item) => sum + item.count,
		0,
	);

	return (
		<>
			<Head title="Rekap Kwitansi" />

			<div className="space-y-6">
				{/* Header with Year Filter */}
				<div className="flex flex-wrap justify-between items-center gap-4">
					<h1 className="font-bold text-2xl">Rekap Kwitansi</h1>
					<div className="flex items-center gap-2">
						<span className="text-sm text-muted-foreground">Data Tahun:</span>
						<Select value={String(tahun)} onValueChange={handleYearChange}>
							<SelectTrigger className="w-[120px]">
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
				</div>

				{/* Ringkasan */}
				<section>
					<h3 className="mb-4 font-semibold text-xl">Ringkasan</h3>
					<div className="gap-4 grid md:grid-cols-2 lg:grid-cols-3">
						<StatsCard
							title={formatCurrency(danaKelola)}
							subtitle="Dana Masuk"
							icon={Banknote}
							iconClassName="bg-amber-500"
						/>
						<StatsCard
							title={`${totalKwitansi}`}
							subtitle="Jumlah Kwitansi"
							icon={FileText}
							iconClassName="bg-sky-500"
						/>
						<StatsCard
							title={`${Object.keys(jenisPembayaran).length}`}
							subtitle="Jenis Pembayaran"
							icon={ReceiptText}
							iconClassName="bg-emerald-500"
						/>
					</div>
				</section>

				{/* Stats per Jenis Pembayaran */}
				{Object.keys(jenisPembayaran).length > 0 && (
					<section>
						<h3 className="mb-4 font-semibold text-xl">
							Statistik per Jenis Pembayaran
						</h3>
						<div className="gap-4 grid md:grid-cols-2 lg:grid-cols-3">
							{Object.entries(jenisPembayaran).map(
								([jenis, data], index) => {
									const Icon =
										JENIS_PEMBAYARAN_ICONS[jenis] || FileText;
									const colorClass =
										JENIS_PEMBAYARAN_COLORS[jenis] ||
										JENIS_PEMBAYARAN_FALLBACK_COLORS[
											index % JENIS_PEMBAYARAN_FALLBACK_COLORS.length
										];

									return (
										<StatsCard
											key={jenis}
											title={formatCurrency(data.total)}
											subtitle={`${jenis} · ${data.count} kwitansi`}
											icon={Icon}
											iconClassName={colorClass}
										/>
									);
								},
							)}
						</div>
					</section>
				)}

				{/* Riwayat Kwitansi Terakhir */}
				<Card>
					<CardHeader className="flex flex-row justify-between items-center">
						<CardTitle>Riwayat Kwitansi Terakhir</CardTitle>
						<Button asChild variant="outline" size="sm">
							<a
								href={`${route("ppdb.rekap.kwitansi-riwayat")}?tahun=${tahun}`}
								target="_blank"
							>
								Export .xlsx
							</a>
						</Button>
					</CardHeader>
					<CardContent>
						{/* Filters */}
						<div className="flex flex-col sm:flex-row gap-3 mb-4">
							<div className="relative flex-1">
								<Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
								<Input
									placeholder="Cari nama atau no. pendaftaran..."
									value={search}
									onChange={(e) => setSearch(e.target.value)}
									className="pl-8 h-10"
								/>
							</div>
							<div className="w-full sm:w-48">
								<Select
									value={jenisPembayaranFilter || "all"}
									onValueChange={handleJenisPembayaranChange}
								>
									<SelectTrigger>
										<SelectValue placeholder="Semua Jenis" />
									</SelectTrigger>
									<SelectContent>
										<SelectItem value="all">Semua Jenis</SelectItem>
										{allJenisPembayaran.map((jenis) => (
											<SelectItem key={jenis} value={jenis}>
												{jenis}
											</SelectItem>
										))}
									</SelectContent>
								</Select>
							</div>
							<div className="w-full sm:w-44">
								<Select
									value={statusFilter || "all"}
									onValueChange={handleStatusChange}
								>
									<SelectTrigger>
										<SelectValue placeholder="Semua Status" />
									</SelectTrigger>
									<SelectContent>
										<SelectItem value="all">Semua Status</SelectItem>
										<SelectItem value="active">Aktif</SelectItem>
										<SelectItem value="deleted">Dihapus</SelectItem>
									</SelectContent>
								</Select>
							</div>
						</div>

						{/* Table */}
						<Table>
							<TableHeader>
								<TableRow>
									<TableHead>
										<TableHeaderLabel icon={Hash}>No. Peserta</TableHeaderLabel>
									</TableHead>
									<TableHead>
										<TableHeaderLabel icon={User}>Nama</TableHeaderLabel>
									</TableHead>
									<TableHead>
										<TableHeaderLabel icon={ReceiptText}>
											Jenis Pembayaran
										</TableHeaderLabel>
									</TableHead>
									<TableHead>
										<TableHeaderLabel icon={Wallet}>Jumlah</TableHeaderLabel>
									</TableHead>
									<TableHead>
										<TableHeaderLabel icon={ClipboardList}>
											Status
										</TableHeaderLabel>
									</TableHead>
									<TableHead>
										<TableHeaderLabel icon={CalendarClock}>
											Tanggal
										</TableHeaderLabel>
									</TableHead>
									<TableHead>
										<TableHeaderLabel icon={Settings2}>Aksi</TableHeaderLabel>
									</TableHead>
								</TableRow>
							</TableHeader>
							<TableBody>
								{kwitansiesHistory.data.length > 0 ? (
									kwitansiesHistory.data.map((k) => (
										<TableRow
											key={k.id}
											className={
												k.deleted_at
													? "bg-red-500/10 dark:bg-red-900/20"
													: ""
											}
										>
											<TableCell>
												<span className="inline-flex items-center gap-1.5">
													<Hash className="size-3.5 shrink-0 text-muted-foreground" />
													{k.peserta_ppdb?.no_pendaftaran}
												</span>
											</TableCell>
											<TableCell>
												<span className="inline-flex items-center gap-1.5">
													<User className="size-3.5 shrink-0 text-muted-foreground" />
													{k.peserta_ppdb?.nama_lengkap}
												</span>
											</TableCell>
											<TableCell>
												<span className="inline-flex items-center gap-1.5">
													<ReceiptText className="size-3.5 shrink-0 text-muted-foreground" />
													{k.jenis_pembayaran}
												</span>
											</TableCell>
											<TableCell>
												<span className="inline-flex items-center gap-1.5 font-medium">
													<Wallet className="size-3.5 shrink-0 text-muted-foreground" />
													{formatCurrency(k.nominal)}
												</span>
											</TableCell>
											<TableCell>
												{k.deleted_at ? (
													<span className="inline-flex items-center gap-1 text-xs font-medium text-red-600 dark:text-red-400">
														<Trash2 className="h-3 w-3" />
														Dihapus
													</span>
												) : (
													<span className="inline-flex items-center gap-1 text-xs font-medium text-green-600 dark:text-green-400">
														<FileCheck className="h-3 w-3" />
														Aktif
													</span>
												)}
											</TableCell>
											<TableCell>
												<span className="inline-flex items-center gap-1.5 text-sm text-muted-foreground">
													<CalendarClock className="size-3.5 shrink-0" />
													{format(new Date(k.created_at), "dd/MM/yy HH:mm")}
												</span>
											</TableCell>
											<TableCell>
												{!k.deleted_at ? (
													<Button
														type="button"
														size="sm"
														variant="secondary"
														disabled={isPrinting}
														onClick={() =>
															printFromRoute(
																route("ppdb.cetak.kwitansi.single", {
																	uuid: k.peserta_ppdb.id,
																	id: k.id,
																}),
																`kwitansi-${k.id}`,
															)
														}
													>
														{printingDocumentId === `kwitansi-${k.id}` ? (
															"Memuat..."
														) : (
															<>
																<Printer className="size-3.5" />
																Cetak
															</>
														)}
													</Button>
												) : (
													<span className="text-xs text-destructive">
														dihapus oleh {k.deleted_by?.name}
													</span>
												)}
											</TableCell>
										</TableRow>
									))
								) : (
									<TableRow>
										<TableCell colSpan={7} className="text-center">
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

			<PrintFrame />
		</>
	);
}

function StatsCard({
	title,
	subtitle,
	icon: Icon,
	iconClassName,
}: {
	title: string;
	subtitle: string;
	icon: React.ComponentType<{ className?: string }>;
	iconClassName?: string;
}) {
	return (
		<Card className="py-4">
			<div className="flex items-center px-4 gap-4">
				<div className={cn("p-3 rounded-lg shrink-0", iconClassName)}>
					<Icon className="w-6 h-6 text-white" />
				</div>
				<div>
					<div className="text-2xl font-bold leading-none">{title}</div>
					<div className="text-sm font-medium text-muted-foreground mt-1">
						{subtitle}
					</div>
				</div>
			</div>
		</Card>
	);
}

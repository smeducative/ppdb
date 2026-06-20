import { type Column, DataTable } from "@/components/data-table";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { cn } from "@/lib/utils";
import { formatDate } from "@/lib/date";
import { Head, Link, router } from "@inertiajs/react";
import {
	Banknote,
	FileCheck,
	FileText,
	ReceiptText,
} from "lucide-react";

interface Jurusan {
	id: number;
	nama: string;
	abbreviation: string;
}

interface Kwitansi {
	id: number;
	jenis_pembayaran: string;
	nominal: number;
}

interface Peserta {
	id: string;
	no_pendaftaran: string;
	nama_lengkap: string;
	tempat_lahir: string;
	tanggal_lahir: string;
	no_hp: string;
	asal_sekolah: string;
	jurusan: Jurusan;
	created_at: string;
	kwitansi: Kwitansi[];
}

interface PaginationLink {
	url: string | null;
	label: string;
	active: boolean;
}

interface JenisPembayaran {
	[key: string]: {
		count: number;
		total: number;
	};
}

interface Props {
	pesertappdb: {
		data: Peserta[];
		links: PaginationLink[];
		current_page: number;
		last_page: number;
		total: number;
	};
	tahun: number;
	years: number[];
	jurusan: string | null;
	danaKelola: number;
	jenisPembayaran: JenisPembayaran;
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

export default function Index({
	pesertappdb,
	tahun,
	years,
	jurusan,
	danaKelola,
	jenisPembayaran,
}: Props) {
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

	const columns: Column<Peserta>[] = [
		{
			accessorKey: "no_pendaftaran",
			header: "No. Pendaftaran",
			cell: ({ row }) => (
				<div className="font-medium">{row.getValue("no_pendaftaran")}</div>
			),
		},
		{
			accessorKey: "nama_lengkap",
			header: "Nama Lengkap",
			cell: ({ row }) => (
				<Link
					href={route("ppdb.kwitansi.tambah", { uuid: row.original.id })}
					className="text-primary hover:underline font-medium"
				>
					{row.getValue("nama_lengkap")}
				</Link>
			),
		},
		{
			accessorKey: "ttl",
			header: "Tempat, Tanggal Lahir",
			cell: ({ row }) => {
				return (
					<div>
						{row.original.tempat_lahir},{" "}
						{formatDate(row.original.tanggal_lahir)}
					</div>
				);
			},
		},
		{
			accessorKey: "no_hp",
			header: "No. HP",
		},
		{
			accessorKey: "asal_sekolah",
			header: "Asal Sekolah",
		},
		{
			accessorKey: "jurusan.nama",
			header: "Jurusan",
		},
		{
			id: "kwitansi_count",
			header: "Kwitansi",
			cell: ({ row }) => {
				const kwitansi = row.original.kwitansi;
				return (
					<div>
						<span className="font-bold">{kwitansi.length}</span>
						<span className="text-xs text-muted-foreground ml-1">
							({kwitansi.map((k) => k.jenis_pembayaran).join(", ")})
						</span>
					</div>
				);
			},
		},
		{
			id: "total_bayar",
			header: "Terbayar",
			cell: ({ row }) => {
				const total = row.original.kwitansi.reduce(
					(sum, k) => sum + k.nominal,
					0,
				);
				return (
					<div className="font-bold text-green-600 dark:text-green-400">
						{formatCurrency(total)}
					</div>
				);
			},
		},
	];

	const handleYearChange = (value: string) => {
		router.get(
			route("ppdb.kwitansi.show"),
			{ tahun: value, jurusan },
			{ preserveState: true },
		);
	};

	return (
		<>
			<Head title="Dashboard Kwitansi" />

			<div className="space-y-6">
				{/* Header with Year Filter */}
				<div className="flex flex-wrap justify-between items-center gap-4">
					<h1 className="font-bold text-2xl">Dashboard Kwitansi</h1>
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
							title="Dana Masuk"
							subtitle={formatCurrency(danaKelola)}
							icon={Banknote}
							iconClassName="bg-amber-500"
						/>
						<StatsCard
							title="Jumlah Kwitansi"
							subtitle={`${totalKwitansi} transaksi`}
							icon={FileText}
							iconClassName="bg-sky-500"
						/>
						<StatsCard
							title="Jenis Pembayaran"
							subtitle={`${Object.keys(jenisPembayaran).length} jenis`}
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
											title={jenis}
											subtitle={`${data.count} kwitansi · ${formatCurrency(data.total)}`}
											icon={Icon}
											iconClassName={colorClass}
										/>
									);
								},
							)}
						</div>
					</section>
				)}

				<div className="space-y-4">
					<div className="bg-blue-500/10 border-l-4 border-blue-500 p-4 rounded text-blue-700 dark:text-blue-400 text-sm">
						<p className="font-bold">Info!</p>
						<p>
							Peserta yang tampil di halaman ini adalah peserta yang telah
							dinyatakan <strong>diterima</strong>. Setelah peserta dinyatakan
							diterima, peserta melakukan daftar ulang dengan melakukan
							pembayaran kwitansi daftar ulang.
						</p>
					</div>
					<div className="bg-blue-500/10 border-l-4 border-blue-500 p-4 rounded text-blue-700 dark:text-blue-400 text-sm">
						<p className="font-bold">Tips!</p>
						<p>Klik nama peserta untuk mengisi kwitansi.</p>
					</div>
				</div>

				<DataTable
					columns={columns}
					data={pesertappdb.data}
					pagination={{ links: pesertappdb.links }}
					searchPlaceholder="Cari nama, no pend, asal sekolah..."
					additionalParams={{ jurusan }}
				/>
			</div>
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

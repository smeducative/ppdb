import { type Column, DataTable } from "@/components/data-table";
import { ExportStatusDialog } from "@/components/export-status-dialog";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { Head, Link, router } from "@inertiajs/react";
import {
	CheckCircle2,
	ClipboardList,
	Eye,
	GraduationCap,
	Hash,
	Phone,
	School,
	Settings2,
	User,
	XCircle,
} from "lucide-react";

interface Jurusan {
	id: number;
	nama: string;
	abbreviation: string;
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
	diterima: number;
}

interface PaginationLink {
	url: string | null;
	label: string;
	active: boolean;
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
}

export default function ListBelumDaftarUlang({
	pesertappdb,
	tahun,
	years,
	jurusan,
}: Props) {
	const columns: Column<Peserta>[] = [
		{
			accessorKey: "no_pendaftaran",
			header: "No. Pendaftaran",
			icon: Hash,
			cell: ({ row }) => (
				<Link
					href={route("ppdb.show.peserta", row.original.id)}
					className="inline-flex items-center gap-1.5 font-medium text-primary hover:underline"
				>
					<Hash className="size-3.5 shrink-0 text-muted-foreground" />
					{row.getValue("no_pendaftaran")}
				</Link>
			),
		},
		{
			accessorKey: "nama_lengkap",
			header: "Nama Lengkap",
			icon: User,
			cell: ({ row }) => (
				<div className="inline-flex items-center gap-1.5 font-medium">
					<User className="size-3.5 shrink-0 text-muted-foreground" />
					{row.getValue("nama_lengkap")}
				</div>
			),
		},
		{
			header: "Jurusan",
			icon: GraduationCap,
			cell: ({ row }) => (
				<div className="inline-flex items-center gap-1.5 text-sm font-medium">
					<GraduationCap className="size-3.5 shrink-0 text-muted-foreground" />
					{row.original.jurusan?.abbreviation ||
						row.original.jurusan?.nama ||
						"-"}
				</div>
			),
		},
		{
			accessorKey: "asal_sekolah",
			header: "Asal Sekolah",
			icon: School,
			cell: ({ row }) => (
				<div
					className="inline-flex max-w-[200px] items-center gap-1.5 truncate text-sm text-muted-foreground"
					title={row.original.asal_sekolah}
				>
					<School className="size-3.5 shrink-0" />
					{row.original.asal_sekolah}
				</div>
			),
		},
		{
			accessorKey: "no_hp",
			header: "No. HP",
			icon: Phone,
			cell: ({ row }) => (
				<a
					href={`https://wa.me/${row.original.no_hp}`}
					target="_blank"
					rel="noreferrer"
					className="inline-flex items-center gap-1.5 font-medium text-green-600 hover:underline dark:text-green-400"
				>
					<Phone className="size-3.5 shrink-0" />
					{row.getValue("no_hp")}
				</a>
			),
		},
		{
			accessorKey: "diterima",
			header: "Status",
			icon: ClipboardList,
			cell: ({ row }) => {
				const status = row.getValue("diterima");
				if (status === 1) {
					return (
						<Badge className="bg-green-500 hover:bg-green-600">
							<CheckCircle2 className="size-3.5" />
							Diterima
						</Badge>
					);
				} else if (status === 2) {
					return (
						<Badge variant="destructive">
							<XCircle className="size-3.5" />
							Ditolak
						</Badge>
					);
				} else {
					return (
						<Badge
							variant="secondary"
							className="border-yellow-500/20 bg-yellow-500/10 text-yellow-600 hover:bg-yellow-500/20 dark:text-yellow-400"
						>
							<ClipboardList className="size-3.5" />
							Belum Diverifikasi
						</Badge>
					);
				}
			},
		},
		{
			id: "actions",
			header: "Aksi",
			icon: Settings2,
			cell: ({ row }) => (
				<Button asChild size="sm" variant="outline">
					<Link href={route("ppdb.show.peserta", row.original.id)}>
						<Eye className="size-3.5" />
						Lihat
					</Link>
				</Button>
			),
		},
	];

	const handleYearChange = (value: string) => {
		router.get(
			window.location.pathname,
			{ tahun: value },
			{ preserveState: true },
		);
	};

	return (
		<>
			<Head title="List Peserta Belum Daftar Ulang" />

			<div className="space-y-6">
				<div className="flex flex-col justify-between gap-4 sm:flex-row">
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

					<div className="flex items-center gap-2">
						<ExportStatusDialog
							routeName="export.belum.daftar.ulang"
							params={{ tahun, jurusan: jurusan || "" }}
							defaultStatus="belum_du"
						/>
					</div>
				</div>

				<div className="rounded border-l-4 border-blue-500 bg-blue-500/10 p-4 text-sm text-blue-700 dark:text-blue-400">
					<p className="font-bold">Info!</p>
					<p>
						Peserta yang belum melakukan pembayaran daftar ulang akan tampil
						disini. Jika peserta belum tampil, silahkan melakukan proses daftar
						ulang di menu kwitansi.
					</p>
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

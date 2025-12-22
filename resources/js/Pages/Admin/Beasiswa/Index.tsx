import { AlertMessages } from "@/components/alert-messages";
import { type Column, DataTable } from "@/components/data-table";
import { Button } from "@/components/ui/button";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { formatDate } from "@/lib/date";
import { Head, Link, router } from "@inertiajs/react";

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
	tanggal_lahir: string; // ISO date string
	no_hp: string;
	asal_sekolah: string;
	jurusan: Jurusan;
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
	title: string;
}

export default function Index({ pesertappdb, tahun, years, title }: Props) {
	const { flash } = usePage<any>().props;

	const columns: Column<Peserta>[] = [
		{
			header: "Identitas Peserta",
			className: "min-w-[200px]",
			cell: ({ row }) => (
				<div className="flex flex-col">
					<span className="font-mono text-muted-foreground text-xs">
						{row.original.no_pendaftaran}
					</span>
					<Link
						href={route("ppdb.show.peserta", row.original.id)}
						className="font-bold text-primary hover:underline"
					>
						{row.original.nama_lengkap}
					</Link>
					<span className="sm:hidden mt-1 text-blue-600 text-muted-foreground dark:text-blue-400 text-xs">
						{row.original.jurusan?.nama || "-"}
					</span>
				</div>
			),
		},
		{
			header: "Info Peserta",
			className: "hidden md:table-cell",
			cell: ({ row }) => (
				<div className="flex flex-col text-sm">
					<div className="flex items-center gap-1">
						<span className="text-muted-foreground">TTL:</span>
						<span>
							{row.original.tempat_lahir},{" "}
							{formatDate(row.original.tanggal_lahir)}
						</span>
					</div>
					<div className="flex items-center gap-1">
						<span className="text-muted-foreground">Asal:</span>
						<span className="max-w-[150px] truncate">
							{row.original.asal_sekolah}
						</span>
					</div>
				</div>
			),
		},
		{
			header: "Kontak",
			className: "hidden sm:table-cell",
			cell: ({ row }) => (
				<a
					href={`https://wa.me/${row.original.no_hp}`}
					target="_blank"
					rel="noreferrer"
					className="flex items-center gap-1 font-medium text-green-600 dark:text-green-400 text-sm hover:underline"
				>
					{row.original.no_hp}
				</a>
			),
		},
		{
			header: "Jurusan",
			className: "hidden sm:table-cell",
			cell: ({ row }) => (
				<div className="font-medium text-sm">
					{row.original.jurusan?.abbreviation ||
						row.original.jurusan?.nama ||
						"-"}
				</div>
			),
		},
	];

	const handleYearChange = (value: string) => {
		router.visit(window.location.pathname, {
			data: { tahun: value },
			preserveState: true,
		});
	};

	return (
		<>
			<Head title={title} />

			<div className="space-y-6">
				<AlertMessages flash={flash} />

				<div
					className="bg-blue-500/10 p-4 border-blue-500 border-l-4 rounded text-blue-700 dark:text-blue-400"
					role="alert"
				>
					<p className="font-bold">Info!</p>
					<p>
						Daftar Peserta yang menerima <strong>{title}</strong>.
					</p>
				</div>

				<div className="flex sm:flex-row flex-col justify-between gap-4">
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
						<Button asChild>
							<a
								href={route(route().current() as string, {
									tahun: tahun,
									export: 1,
								})}
							>
								Export Excel
							</a>
						</Button>
					</div>
				</div>

				<DataTable
					columns={columns}
					data={pesertappdb.data}
					pagination={{ links: pesertappdb.links }}
					searchEndpoint={window.location.pathname}
					searchPlaceholder="Cari nama..."
				/>
			</div>
		</>
	);
}

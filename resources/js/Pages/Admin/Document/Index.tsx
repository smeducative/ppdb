import { AlertMessages } from "@/components/alert-messages";
import { type Column, DataTable } from "@/components/data-table";
import { Button } from "@/components/ui/button";
import {
	Card,
	CardContent,
	CardFooter,
	CardHeader,
	CardTitle,
} from "@/components/ui/card";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { usePrintRoute } from "@/hooks/use-print-route";
import { formatDate, formatDateFull } from "@/lib/date";
import { Head, Link, router, usePage } from "@inertiajs/react";
import {
	CalendarClock,
	GraduationCap,
	Hash,
	Info,
	Printer,
	School,
	Settings2,
	User,
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
}

interface PaginationLink {
	url: string | null;
	label: string;
	active: boolean;
}

interface Settings {
	no_surat: string;
	batas_akhir_ppdb: string | null;
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
	jurusan: string;
	title: string;
	printSingleRoute: string;
	printAllRoute: string;
	showSettings: boolean;
	settings?: Settings;
}

const PRINT_ALL_ID = "all";

export default function Index({
	pesertappdb,
	tahun,
	years,
	jurusan,
	title,
	printSingleRoute,
	printAllRoute,
	showSettings,
	settings,
}: Props) {
	const { flash } = usePage().props;
	const { printFromRoute, printingDocumentId, isPrinting, PrintFrame } =
		usePrintRoute();

	const columns: Column<Peserta>[] = [
		{
			header: "Identitas Peserta",
			icon: User,
			className: "min-w-[200px]",
			cell: ({ row }) => (
				<div className="flex flex-col gap-0.5">
					<span className="inline-flex items-center gap-1 font-mono text-xs text-muted-foreground">
						<Hash className="size-3 shrink-0" />
						{row.original.no_pendaftaran}
					</span>
					<Link
						href={route("ppdb.show.peserta", row.original.id)}
						className="font-bold text-primary hover:underline"
					>
						{row.original.nama_lengkap}
					</Link>
					<span className="mt-1 inline-flex items-center gap-1 text-xs text-muted-foreground sm:hidden">
						<GraduationCap className="size-3 shrink-0" />
						{row.original.jurusan?.nama || "-"}
					</span>
				</div>
			),
		},
		{
			header: "Info Peserta",
			icon: Info,
			className: "hidden md:table-cell",
			cell: ({ row }) => (
				<div className="flex flex-col gap-1 text-sm">
					<div className="flex items-center gap-1.5">
						<CalendarClock className="size-3.5 shrink-0 text-muted-foreground" />
						<span>
							{row.original.tempat_lahir},{" "}
							{formatDate(row.original.tanggal_lahir)}
						</span>
					</div>
					<div className="flex items-center gap-1.5">
						<School className="size-3.5 shrink-0 text-muted-foreground" />
						<span className="max-w-[150px] truncate">
							{row.original.asal_sekolah}
						</span>
					</div>
				</div>
			),
		},
		{
			header: "Jurusan",
			icon: GraduationCap,
			className: "hidden sm:table-cell",
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
			id: "actions",
			header: "Aksi",
			icon: Settings2,
			cell: ({ row }) => (
				<Button
					type="button"
					size="sm"
					disabled={isPrinting}
					onClick={() =>
						printFromRoute(
							route(printSingleRoute, row.original.id),
							row.original.id,
						)
					}
				>
					{printingDocumentId === row.original.id ? (
						"Memuat..."
					) : (
						<>
							<Printer className="size-3.5" />
							Cetak
						</>
					)}
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
			<Head title={title} />

			<div className="space-y-6">
				<AlertMessages flash={flash} />

				{showSettings && settings && (
					<Card>
						<CardHeader>
							<CardTitle>Pengaturan Surat</CardTitle>
						</CardHeader>
						<CardContent className="space-y-4">
							<div>
								<div className="font-bold">No. Surat:</div>
								<div>{settings.no_surat}</div>
							</div>
							<div>
								<div className="font-bold">Batas Akhir SPMB:</div>
								<div>
									{settings.batas_akhir_ppdb
										? formatDateFull(settings.batas_akhir_ppdb)
										: "-"}
								</div>
							</div>
						</CardContent>
						<CardFooter>
							<Button asChild>
								<Link href={route("ppdb.set.batas.akhir")}>Atur</Link>
							</Button>
						</CardFooter>
					</Card>
				)}

				<Card className="p-4">
					<div className="flex justify-between items-center mb-4">
						<h3 className="text-lg font-bold">{title}</h3>
						<div className="flex items-center gap-2">
							<Button
								type="button"
								disabled={isPrinting}
								onClick={() =>
									printFromRoute(
										route(printAllRoute, { jurusan }),
										PRINT_ALL_ID,
									)
								}
							>
								<span className="mr-2">
									{printingDocumentId === PRINT_ALL_ID
										? "Memuat..."
										: "Cetak Semua"}
								</span>
							</Button>
						</div>
					</div>

					<div className="flex flex-col sm:flex-row justify-between gap-4 mb-4">
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
					</div>

					<DataTable
						columns={columns}
						data={pesertappdb.data}
						pagination={{ links: pesertappdb.links }}
						searchEndpoint={window.location.pathname}
						searchPlaceholder="Cari nama, no pend..."
						additionalParams={{ jurusan }}
					/>
				</Card>
			</div>

			<PrintFrame />
		</>
	);
}

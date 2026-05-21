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
			className: "min-w-[200px]",
			cell: ({ row }) => (
				<div className="flex flex-col">
					<span className="text-xs text-muted-foreground font-mono">
						{row.original.no_pendaftaran}
					</span>
					<Link
						href={route("ppdb.show.peserta", row.original.id)}
						className="text-primary hover:underline font-bold"
					>
						{row.original.nama_lengkap}
					</Link>
					<span className="text-xs sm:hidden text-muted-foreground mt-1">
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
						<span className="truncate max-w-[150px]">
							{row.original.asal_sekolah}
						</span>
					</div>
				</div>
			),
		},
		{
			header: "Jurusan",
			className: "hidden sm:table-cell",
			cell: ({ row }) => (
				<div className="text-sm font-medium">
					{row.original.jurusan?.abbreviation ||
						row.original.jurusan?.nama ||
						"-"}
				</div>
			),
		},
		{
			id: "actions",
			header: "Aksi",
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
					{printingDocumentId === row.original.id ? "Memuat..." : "Cetak"}
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

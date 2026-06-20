import { AlertMessages } from "@/components/alert-messages";
import { type Column, DataTable } from "@/components/data-table";
import { Button } from "@/components/ui/button";
import {
	Dialog,
	DialogContent,
	DialogDescription,
	DialogFooter,
	DialogHeader,
	DialogTitle,
} from "@/components/ui/dialog";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { Textarea } from "@/components/ui/textarea";
import { usePrintRoute } from "@/hooks/use-print-route";
import { formatDate } from "@/lib/date";
import { Head, Link, router, usePage } from "@inertiajs/react";
import { useState } from "react";

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
	printSingleRoute: string;
	printAllRoute: string;
	jenis: string;
	defaultKeterangan: string;
}

const PRINT_ALL_ID = "all";

export default function Index({
	pesertappdb,
	tahun,
	years,
	title,
	printSingleRoute,
	printAllRoute,
	jenis,
	defaultKeterangan,
}: Props) {
	const { flash } = usePage<any>().props;
	const { printFromRoute, printingDocumentId, isPrinting, PrintFrame } =
		usePrintRoute();

	const [modalOpen, setModalOpen] = useState(false);
	const [keterangan, setKeterangan] = useState(defaultKeterangan);
	const [printMode, setPrintMode] = useState<"single" | "all">("single");
	const [selectedId, setSelectedId] = useState<string | null>(null);

	const handleOpenModal = (mode: "single" | "all", id?: string) => {
		setPrintMode(mode);
		setSelectedId(id || null);
		setKeterangan(defaultKeterangan);
		setModalOpen(true);
	};

	const handleConfirmPrint = () => {
		if (printMode === "single" && selectedId) {
			printFromRoute(
				route(printSingleRoute, selectedId) +
					`?keterangan=${encodeURIComponent(keterangan)}`,
				selectedId,
			);
		} else if (printMode === "all") {
			printFromRoute(
				route(printAllRoute, { jenis }) +
					`?keterangan=${encodeURIComponent(keterangan)}`,
				PRINT_ALL_ID,
			);
		}
		setModalOpen(false);
	};

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
		{
			id: "actions",
			header: "Aksi",
			cell: ({ row }) => (
				<Button
					type="button"
					size="sm"
					disabled={isPrinting}
					onClick={() => handleOpenModal("single", row.original.id)}
				>
					Cetak
				</Button>
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
						<Button
							type="button"
							disabled={isPrinting}
							onClick={() => handleOpenModal("all")}
						>
							{printingDocumentId === PRINT_ALL_ID
								? "Memuat..."
								: "Cetak Semua"}
						</Button>
						<Button asChild variant="outline">
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

			{/* Modal Verifikasi Keterangan */}
			<Dialog open={modalOpen} onOpenChange={setModalOpen}>
				<DialogContent className="sm:max-w-lg">
					<DialogHeader>
						<DialogTitle>Verifikasi Keterangan Beasiswa</DialogTitle>
						<DialogDescription>
							Periksa dan edit keterangan beasiswa sebelum mencetak dokumen.
						</DialogDescription>
					</DialogHeader>
					<div className="space-y-2">
						<label
							htmlFor="keterangan"
							className="text-sm font-medium leading-none"
						>
							Keterangan Beasiswa
						</label>
						<Textarea
							id="keterangan"
							value={keterangan}
							onChange={(e) => setKeterangan(e.target.value)}
							rows={5}
							className="resize-none"
						/>
					</div>
					<DialogFooter>
						<Button
							variant="outline"
							onClick={() => setModalOpen(false)}
						>
							Batal
						</Button>
						<Button onClick={handleConfirmPrint}>
							{isPrinting ? "Memuat..." : "Cetak"}
						</Button>
					</DialogFooter>
				</DialogContent>
			</Dialog>

			<PrintFrame />
		</>
	);
}

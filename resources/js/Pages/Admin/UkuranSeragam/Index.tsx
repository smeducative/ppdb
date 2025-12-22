import { AlertMessages } from "@/components/alert-messages";
import { DataTable } from "@/components/data-table";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import {
	Dialog,
	DialogContent,
	DialogDescription,
	DialogFooter,
	DialogHeader,
	DialogTitle,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { Head, Link, router, useForm, usePage } from "@inertiajs/react";
import type { ColumnDef } from "@tanstack/react-table";
import { useState } from "react";

interface Jurusan {
	id: number;
	nama: string;
	abbreviation: string;
}

interface UkuranSeragam {
	id: number;
	baju: string | null;
	jas: string | null;
	sepatu: string | null;
	peci: string | null;
}

interface Peserta {
	id: string;
	no_pendaftaran: string;
	nama_lengkap: string;
	jenis_kelamin: "l" | "p";
	jurusan: Jurusan;
	ukuran_seragam: UkuranSeragam | null;
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

export default function Index({ pesertappdb, tahun, years, jurusan }: Props) {
	const { flash } = usePage<any>().props;

	// Edit Modal State
	const [selectedPeserta, setSelectedPeserta] = useState<Peserta | null>(null);
	const [open, setOpen] = useState(false);

	const {
		data: formData,
		setData,
		post,
		processing,
		errors,
		reset,
	} = useForm({
		uuid: "",
		baju: "",
		jas: "",
		sepatu: "",
		peci: "",
	});

	const handleEdit = (peserta: Peserta) => {
		setSelectedPeserta(peserta);
		setData({
			uuid: peserta.id,
			baju: peserta.ukuran_seragam?.baju || "",
			jas: peserta.ukuran_seragam?.jas || "",
			sepatu: peserta.ukuran_seragam?.sepatu || "",
			peci: peserta.ukuran_seragam?.peci || "",
		});
		setOpen(true);
	};

	const submit = (e: React.FormEvent) => {
		e.preventDefault();
		post(route("ppdb.ubah.seragam"), {
			onSuccess: () => {
				setOpen(false);
				reset();
			},
		});
	};

	const columns: ColumnDef<Peserta>[] = [
		{
			accessorKey: "no_pendaftaran",
			header: "No. Pendaftaran",
			cell: ({ row }) => (
				<div>
					<div className="font-medium text-primary">
						{row.getValue("no_pendaftaran")}
					</div>
				</div>
			),
		},
		{
			accessorKey: "nama_lengkap",
			header: "Nama Lengkap",
			cell: ({ row }) => (
				<Link
					href={route("ppdb.show.peserta", row.original.id)}
					className="hover:underline font-medium"
				>
					{row.getValue("nama_lengkap")}
				</Link>
			),
		},
		{
			accessorKey: "jenis_kelamin",
			header: "L/P",
			cell: ({ row }) => (
				<Badge variant="outline">
					{row.getValue("jenis_kelamin") === "l" ? "L" : "P"}
				</Badge>
			),
		},
		{
			id: "baju",
			header: "Baju",
			cell: ({ row }) => row.original.ukuran_seragam?.baju || "-",
		},
		{
			id: "jas",
			header: "Jas",
			cell: ({ row }) => row.original.ukuran_seragam?.jas || "-",
		},
		{
			id: "actions",
			header: "Aksi",
			cell: ({ row }) => (
				<Button size="sm" onClick={() => handleEdit(row.original)}>
					Ubah
				</Button>
			),
		},
	];

	const handleYearChange = (value: string) => {
		router.get(
			route("ppdb.seragam.show.jurusan"),
			{ tahun: value, jurusan },
			{ preserveState: true },
		);
	};

	return (
		<>
			<Head title="Ukuran Seragam Siswa" />

			<div className="space-y-6">
				<AlertMessages flash={flash} />

				<div className="flex flex-col sm:flex-row justify-between gap-4">
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
							<a href={`${route("export.seragam")}?jurusan=${jurusan || ""}`}>
								Export Excel
							</a>
						</Button>
					</div>
				</div>

				<DataTable
					columns={columns}
					data={pesertappdb.data}
					pagination={{ links: pesertappdb.links }}
					searchEndpoint={route("ppdb.seragam.show.jurusan")}
					searchPlaceholder="Cari nama, no pend..."
					additionalParams={{ jurusan }}
				/>

				<Dialog open={open} onOpenChange={setOpen}>
					<DialogContent className="sm:max-w-[425px]">
						<DialogHeader>
							<DialogTitle>Ubah Ukuran Seragam</DialogTitle>
							<DialogDescription>
								{selectedPeserta?.nama_lengkap}
							</DialogDescription>
						</DialogHeader>
						<form onSubmit={submit} className="space-y-4">
							<div className="grid grid-cols-2 gap-4">
								<div className="space-y-2">
									<Label htmlFor="baju">Ukuran Baju</Label>
									<Input
										id="baju"
										value={formData.baju}
										onChange={(e) => setData("baju", e.target.value)}
									/>
								</div>
								<div className="space-y-2">
									<Label htmlFor="jas">Ukuran Jas</Label>
									<Input
										id="jas"
										value={formData.jas}
										onChange={(e) => setData("jas", e.target.value)}
									/>
								</div>
								{/* Sepatu & Peci logic commented out in original blade, keeping it consistent or uncomment if needed */}
							</div>
							<DialogFooter>
								<Button type="submit" disabled={processing}>
									Simpan Perubahan
								</Button>
							</DialogFooter>
						</form>
					</DialogContent>
				</Dialog>
			</div>
		</>
	);
}

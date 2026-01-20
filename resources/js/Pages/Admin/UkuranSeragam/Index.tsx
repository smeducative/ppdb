import { AlertMessages } from "@/components/alert-messages";
import { type Column, DataTable } from "@/components/data-table";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Checkbox } from "@/components/ui/checkbox";
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
	seragam_praktik: boolean;
	baju_batik: boolean;
	seragam_olahraga: boolean;
	jas_almamater: boolean;
	kaos_bintalsik: boolean;
	atribut: boolean;
	kegiatan_bintalsik: boolean;
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
		seragam_praktik: false,
		baju_batik: false,
		seragam_olahraga: false,
		jas_almamater: false,
		kaos_bintalsik: false,
		atribut: false,
		kegiatan_bintalsik: false,
	});

	const handleEdit = (peserta: Peserta) => {
		setSelectedPeserta(peserta);
		setData({
			uuid: peserta.id,
			baju: peserta.ukuran_seragam?.baju || "",
			jas: peserta.ukuran_seragam?.jas || "",
			sepatu: peserta.ukuran_seragam?.sepatu || "",
			peci: peserta.ukuran_seragam?.peci || "",
			seragam_praktik: peserta.ukuran_seragam?.seragam_praktik || false,
			baju_batik: peserta.ukuran_seragam?.baju_batik || false,
			seragam_olahraga: peserta.ukuran_seragam?.seragam_olahraga || false,
			jas_almamater: peserta.ukuran_seragam?.jas_almamater || false,
			kaos_bintalsik: peserta.ukuran_seragam?.kaos_bintalsik || false,
			atribut: peserta.ukuran_seragam?.atribut || false,
			kegiatan_bintalsik: peserta.ukuran_seragam?.kegiatan_bintalsik || false,
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

	const columns: Column<Peserta>[] = [
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
					className="font-medium hover:underline"
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
								href={route("export.seragam", {
									tahun: tahun,
									jurusan: jurusan || "",
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
					searchPlaceholder="Cari nama, no pend..."
					additionalParams={{ jurusan }}
				/>

				<Dialog open={open} onOpenChange={setOpen}>
					<DialogContent className="sm:max-w-[600px]">
						<DialogHeader>
							<DialogTitle>Ubah Ukuran Seragam</DialogTitle>
							<DialogDescription>
								{selectedPeserta?.nama_lengkap}
							</DialogDescription>
						</DialogHeader>
						<form onSubmit={submit} className="space-y-6">
							<div className="gap-4 grid grid-cols-2">
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
							</div>

							<div className="space-y-4">
								<Label className="text-base font-semibold">Ceklist Kelengkapan</Label>
								<div className="gap-4 grid grid-cols-2">
									<div className="flex items-center space-x-2">
										<Checkbox
											id="seragam_praktik"
											checked={formData.seragam_praktik}
											onCheckedChange={(checked) =>
												setData("seragam_praktik", !!checked)
											}
										/>
										<Label htmlFor="seragam_praktik">Seragam Praktik</Label>
									</div>
									<div className="flex items-center space-x-2">
										<Checkbox
											id="baju_batik"
											checked={formData.baju_batik}
											onCheckedChange={(checked) =>
												setData("baju_batik", !!checked)
											}
										/>
										<Label htmlFor="baju_batik">Baju Batik</Label>
									</div>
									<div className="flex items-center space-x-2">
										<Checkbox
											id="seragam_olahraga"
											checked={formData.seragam_olahraga}
											onCheckedChange={(checked) =>
												setData("seragam_olahraga", !!checked)
											}
										/>
										<Label htmlFor="seragam_olahraga">Seragam Olahraga</Label>
									</div>
									<div className="flex items-center space-x-2">
										<Checkbox
											id="jas_almamater"
											checked={formData.jas_almamater}
											onCheckedChange={(checked) =>
												setData("jas_almamater", !!checked)
											}
										/>
										<Label htmlFor="jas_almamater">Jas Almamater</Label>
									</div>
									<div className="flex items-center space-x-2">
										<Checkbox
											id="kaos_bintalsik"
											checked={formData.kaos_bintalsik}
											onCheckedChange={(checked) =>
												setData("kaos_bintalsik", !!checked)
											}
										/>
										<Label htmlFor="kaos_bintalsik">Kaos Bintalsik</Label>
									</div>
									<div className="flex items-center space-x-2">
										<Checkbox
											id="atribut"
											checked={formData.atribut}
											onCheckedChange={(checked) =>
												setData("atribut", !!checked)
											}
										/>
										<Label htmlFor="atribut">Atribut</Label>
									</div>
									<div className="flex items-center space-x-2">
										<Checkbox
											id="kegiatan_bintalsik"
											checked={formData.kegiatan_bintalsik}
											onCheckedChange={(checked) =>
												setData("kegiatan_bintalsik", !!checked)
											}
										/>
										<Label htmlFor="kegiatan_bintalsik">Kegiatan Bintalsik</Label>
									</div>
								</div>
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

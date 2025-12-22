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
import { Head, Link, router, usePage } from "@inertiajs/react";
import { format } from "date-fns";

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
	printSingleRoute: string; // Route name, e.g. 'ppdb.cetak.surat'
	printAllRoute: string; // Route name, e.g. 'ppdb.cetak.surat.semua'
	showSettings: boolean;
	settings?: Settings;
}

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
	const { flash, csrf_token } = usePage<any>().props;

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
					className="hover:underline font-medium"
				>
					{row.getValue("nama_lengkap")}
				</Link>
			),
		},
		{
			id: "ttl",
			header: "Tempat, Tanggal Lahir",
			cell: ({ row }) => {
				const date = new Date(row.original.tanggal_lahir);
				return `${row.original.tempat_lahir}, ${format(date, "dd-MM-yyyy")}`;
			},
		},
		{
			accessorKey: "no_hp",
			header: "No. Telepon",
		},
		{
			accessorKey: "asal_sekolah",
			header: "Asal Sekolah",
		},
		{
			accessorKey: "jurusan.nama",
			header: "Pilihan Jurusan",
		},
		{
			id: "actions",
			header: "Aksi",
			cell: ({ row }) => (
				<form action={route(printSingleRoute, row.original.id)} method="POST">
					<input type="hidden" name="_token" value={csrf_token} />
					<Button type="submit" size="sm">
						Cetak
					</Button>
				</form>
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

	const handlePrintAll = (e: React.FormEvent) => {
		// Since we need to submit a POST request to open in new tab (maybe?), strict HTML form is better for this than Inertia router which expects JSON/XHR usually unless we use window.open
		// In the original blade:
		// <form action="{{ route('ppdb.cetak.surat.semua', ['jurusan' => $jurusan]) }}" method="POST">
		// So we should replicate that behavior using a real form or helper.
		// We can render a real form hidden or just use the onSubmit to create one.
		// Or actually just put a form around the button.
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
								<div className="font-bold">Batas Akhir PPDB:</div>
								<div>
									{settings.batas_akhir_ppdb
										? format(
												new Date(settings.batas_akhir_ppdb),
												"EEEE, d MMMM yyyy",
											)
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
							<form
								action={route(printAllRoute, { jurusan })}
								method="POST"
								target="_blank"
							>
								<input
									type="hidden"
									name="_token"
									value={(usePage().props as any).csrf_token}
								/>
								<Button type="submit">
									<span className="mr-2">Cetak Semua</span>
								</Button>
							</form>
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
		</>
	);
}

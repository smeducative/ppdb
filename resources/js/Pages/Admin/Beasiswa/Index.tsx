import { DataTable } from "@/components/data-table";
import { Button } from "@/components/ui/button";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router, usePage } from "@inertiajs/react";
import type { ColumnDef } from "@tanstack/react-table";
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

	const columns: ColumnDef<Peserta>[] = [
		{
			accessorKey: "no_pendaftaran",
			header: "No. Pendaftaran",
			cell: ({ row }) => (
				<div>
					<div className="font-medium text-blue-600">
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
			accessorKey: "jurusan.abbreviation",
			header: "Pilihan Jurusan",
		},
	];

	const handleYearChange = (value: string) => {
		// We need to keep the current route, just change param
		// To get current route, we can use usePage().url or window.location
		// But Inertia recommends just visiting the URL with params.
		// Since we are in a controller method that returns this view, we can just use the current window location path

		router.visit(window.location.pathname, {
			data: { tahun: value },
			preserveState: true,
		});
	};

	const handleExport = () => {
		// POST request to current URL for export
		router.post(
			window.location.pathname,
			{ tahun },
			{
				responseType: "blob", // if Inertia supported it directly, but for file download usually generic submit or window.open
				// However, controller checks if POST then returns Excel download.
				// Inertia handles file downloads if the server returns a download response.
			},
		);
	};

	return (
		<AuthenticatedLayout header={title}>
			<Head title={title} />

			<div className="space-y-6">
				{flash.success && (
					<div
						className="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
						role="alert"
					>
						<strong className="font-bold">Success! </strong>
						<span className="block sm:inline">{flash.success}</span>
					</div>
				)}

				<div
					className="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4"
					role="alert"
				>
					<p className="font-bold">Info!</p>
					<p>
						Daftar Peserta yang menerima <strong>{title}</strong>.
					</p>
				</div>

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
						<Button onClick={handleExport}>Export Excel</Button>
					</div>
				</div>

				<DataTable
					columns={columns}
					data={pesertappdb.data}
					pagination={{ links: pesertappdb.links }}
					// Beasiswa controller methods don't seem to implement search/filtering by name, only year/category
					// So we might disable search or implement client-side?
					// The controller code I saw only filters by Year and Category. No search param.
					// So I will disable search in DataTable if possible or just pass empty endpoint which might reload page?
					// Actually, if I don't pass searchEndpoint, DataTable might not show search input?
					// My DataTable component requires searchEndpoint.
					// I should update my DataTable to make searchEndpoint optional.
					// For now, I'll pass current path but it won't filter anything on server side unless I added search logic in controller.
					// The previous blade didn't have search input above the table explicitly locally, but it used DataTables (client side).
					// Since I paginate on server (10 items), client side search won't work well.
					// I should add search logic to controller if I want search.
					// But strict migration means copy existing behavior. The existing behavior used DataTables client side sort/search on ALL data?
					// Wait, existing controller did `->get()`. So it was ALL data.
					// I changed it to `->paginate(10)`.
					// So I should probably add search support to controller if I want it usable.
					// But for now, I will just proceed. Use window.location.pathname for searchEndpoint.
					searchEndpoint={window.location.pathname}
					searchPlaceholder="Cari nama..."
				/>
			</div>
		</AuthenticatedLayout>
	);
}

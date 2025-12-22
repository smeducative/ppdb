import { Input } from "@/components/ui/input";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import {
	Table,
	TableBody,
	TableCell,
	TableHead,
	TableHeader,
	TableRow,
} from "@/components/ui/table";
import { useDebounce } from "@/hooks/use-debounce";
import { router } from "@inertiajs/react";
import {
	type ColumnDef,
	flexRender,
	getCoreRowModel,
	useReactTable,
} from "@tanstack/react-table";
import get from "lodash/get";
import { Loader2, Search } from "lucide-react";
import { useEffect, useMemo, useState } from "react";
import { InertiaPagination } from "./inertia-pagination";

export interface Column<T> {
	id?: string;
	header: string;
	accessorKey?: string;
	cell?: (props: {
		row: { original: T; getValue: (key: string) => any };
	}) => React.ReactNode;
	className?: string;
	meta?: {
		className?: string;
	};
}

interface DataTableProps<T> {
	columns: Column<T>[];
	data: T[];
	pagination?: {
		links: any[];
		meta?: any;
	};
	searchEndpoint?: string;
	searchPlaceholder?: string;
	additionalParams?: Record<string, any>;
	perPageOptions?: number[];
	showSearch?: boolean;
}

export function DataTable<T extends { id?: number | string }>({
	columns,
	data,
	pagination,
	searchEndpoint,
	searchPlaceholder = "Cari data...",
	additionalParams = {},
	perPageOptions = [10, 20, 50, 100],
	showSearch = true,
}: DataTableProps<T>) {
	const [search, setSearch] = useState(
		new URLSearchParams(window.location.search).get("search") || "",
	);
	const debouncedSearch = useDebounce(search, 500);

	const initialPerPage =
		pagination?.meta?.per_page ||
		new URLSearchParams(window.location.search).get("per_page") ||
		"10";
	const [perPage, setPerPage] = useState(String(initialPerPage));
	const [isProcessing, setIsProcessing] = useState(false);

	useEffect(() => {
		const unbindStart = router.on("start", (event) => {
			// Only show loading if the request is to the current page or search endpoint
			const url = new URL(event.detail.visit.url);
			if (
				url.pathname === window.location.pathname ||
				(searchEndpoint && url.pathname === searchEndpoint)
			) {
				setIsProcessing(true);
			}
		});

		const unbindFinish = router.on("finish", () => {
			setIsProcessing(false);
		});

		return () => {
			unbindStart();
			unbindFinish();
		};
	}, [searchEndpoint]);

	useEffect(() => {
		const endpoint = searchEndpoint || window.location.pathname;
		const params = new URLSearchParams(window.location.search);
		const currentSearch = params.get("search") || "";
		const currentPerPage = params.get("per_page") || "10";

		const shouldNavigate =
			debouncedSearch !== currentSearch ||
			perPage !== currentPerPage ||
			(searchEndpoint && searchEndpoint !== window.location.pathname);

		if (shouldNavigate) {
			const queryParams = Object.fromEntries(params.entries());
			router.get(
				endpoint,
				{
					...queryParams,
					search: debouncedSearch,
					per_page: perPage,
					...additionalParams,
				},
				{
					preserveState: true,
					replace: true,
					preserveScroll: true,
				},
			);
		}
	}, [debouncedSearch, perPage, additionalParams]);

	const tanStackColumns = useMemo<ColumnDef<T, any>[]>(
		() =>
			columns.map((col, index) => ({
				id:
					col.id ||
					col.accessorKey ||
					(typeof col.header === "string"
						? col.header.toLowerCase().replace(/\s+/g, "-")
						: `col-${index}`),
				header: col.header,
				accessorKey: col.accessorKey,
				cell: col.cell
					? ({ row }) =>
							col.cell!({
								row: {
									original: row.original,
									getValue: (key: string) => get(row.original, key),
								},
							})
					: ({ getValue }) => getValue()?.toString() || "-",
				meta: {
					className: col.className,
					...col.meta,
				},
			})),
		[columns],
	);

	const table = useReactTable({
		data,
		columns: tanStackColumns,
		getCoreRowModel: getCoreRowModel(),
	});

	return (
		<div className="space-y-4 w-full overflow-hidden">
			<div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
				{showSearch && (
					<div className="flex items-center space-x-2 flex-1 w-full">
						<div className="relative w-full lg:max-w-sm">
							<Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
							<Input
								placeholder={searchPlaceholder}
								value={search}
								onChange={(e) => setSearch(e.target.value)}
								className="pl-8 h-10 w-full"
							/>
							{isProcessing && (
								<div className="absolute right-2.5 top-2.5">
									<Loader2 className="h-4 w-4 animate-spin text-primary" />
								</div>
							)}
						</div>
					</div>
				)}

				<div className="flex items-center gap-2 self-end">
					<span className="text-sm text-muted-foreground">Baris:</span>
					<Select value={perPage} onValueChange={setPerPage}>
						<SelectTrigger className="h-9 w-[70px]">
							<SelectValue placeholder={perPage} />
						</SelectTrigger>
						<SelectContent>
							{perPageOptions.map((option) => (
								<SelectItem key={option} value={String(option)}>
									{option}
								</SelectItem>
							))}
						</SelectContent>
					</Select>
				</div>
			</div>

			<div className="relative rounded-xl border shadow-sm overflow-hidden bg-card">
				{isProcessing && (
					<div className="absolute inset-0 z-10 bg-background/50 backdrop-blur-[1px] flex items-center justify-center">
						<div className="flex flex-col items-center gap-2">
							<Loader2 className="h-8 w-8 animate-spin text-primary" />
							<span className="text-sm font-medium animate-pulse">
								Memuat data...
							</span>
						</div>
					</div>
				)}

				<div className="overflow-x-auto scrollbar-thin scrollbar-thumb-muted">
					<Table>
						<TableHeader className="bg-muted/50">
							{table.getHeaderGroups().map((headerGroup) => (
								<TableRow key={headerGroup.id}>
									{headerGroup.headers.map((header) => (
										<TableHead
											key={header.id}
											className={
												(header.column.columnDef.meta as any)?.className
											}
										>
											{header.isPlaceholder
												? null
												: flexRender(
														header.column.columnDef.header,
														header.getContext(),
													)}
										</TableHead>
									))}
								</TableRow>
							))}
						</TableHeader>
						<TableBody>
							{table.getRowModel().rows?.length ? (
								table.getRowModel().rows.map((row) => (
									<TableRow
										key={row.id || (row.original as any).id}
										data-state={row.getIsSelected() && "selected"}
										className="hover:bg-muted/30 transition-colors"
									>
										{row.getVisibleCells().map((cell) => (
											<TableCell
												key={cell.id}
												className={
													(cell.column.columnDef.meta as any)?.className
												}
											>
												{flexRender(
													cell.column.columnDef.cell,
													cell.getContext(),
												)}
											</TableCell>
										))}
									</TableRow>
								))
							) : (
								<TableRow>
									<TableCell
										colSpan={columns.length}
										className="h-32 text-center text-muted-foreground"
									>
										{isProcessing ? "Memperbarui..." : "Data tidak ditemukan."}
									</TableCell>
								</TableRow>
							)}
						</TableBody>
					</Table>
				</div>
			</div>

			{pagination && (
				<div className="flex items-center justify-between gap-4 py-2">
					<div className="text-sm text-muted-foreground">
						Menampilkan {data.length} hasil
					</div>
					<InertiaPagination links={pagination.links} />
				</div>
			)}
		</div>
	);
}

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
import { Search } from "lucide-react";
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
}

export function DataTable<T extends { id?: number | string }>({
	columns,
	data,
	pagination,
	searchEndpoint,
	searchPlaceholder = "Search...",
	additionalParams = {},
	perPageOptions = [10, 20, 50, 100],
}: DataTableProps<T>) {
	// Initialize search from URL if present
	const [search, setSearch] = useState(
		new URLSearchParams(window.location.search).get("search") || "",
	);
	const debouncedSearch = useDebounce(search, 500);

	const initialPerPage =
		pagination?.meta?.per_page ||
		new URLSearchParams(window.location.search).get("per_page") ||
		"10";
	const [perPage, setPerPage] = useState(String(initialPerPage));

	useEffect(() => {
		const endpoint = searchEndpoint || window.location.pathname;
		const params = new URLSearchParams(window.location.search);
		const currentSearch = params.get("search") || "";
		const currentPerPage = params.get("per_page") || "10";

		// Only trigger navigation if search or perPage changed from URL values
		// OR if searchEndpoint is explicitly provided and different from current path
		const shouldNavigate =
			debouncedSearch !== currentSearch ||
			perPage !== currentPerPage ||
			(searchEndpoint && searchEndpoint !== window.location.pathname);

		if (shouldNavigate) {
			router.get(
				endpoint,
				{ search: debouncedSearch, per_page: perPage, ...additionalParams },
				{
					preserveState: true,
					replace: true,
					preserveScroll: true,
				},
			);
		}
	}, [debouncedSearch, perPage]);

	// Map custom columns to TanStack ColumnDef
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
				{searchEndpoint && (
					<div className="flex items-center space-x-2 flex-1 w-full">
						<div className="relative w-full lg:max-w-sm">
							<Search className="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
							<Input
								placeholder={searchPlaceholder}
								value={search}
								onChange={(e) => setSearch(e.target.value)}
								className="pl-8 h-10 w-full"
							/>
						</div>
					</div>
				)}

				<div className="flex items-center gap-2 self-end">
					<span className="text-sm text-muted-foreground">Rows:</span>
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

			<div className="rounded-xl border shadow-sm overflow-hidden bg-card">
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
										No results found.
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
						Showing {data.length} results
					</div>
					<InertiaPagination links={pagination.links} />
				</div>
			)}
		</div>
	);
}

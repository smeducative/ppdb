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
import get from "lodash/get";
import { Search } from "lucide-react";
import { useEffect, useState } from "react";
import { InertiaPagination } from "./inertia-pagination";

export interface Column<T> {
	id?: string;
	header: string;
	accessorKey?: string;
	cell?: (props: {
		row: { original: T; getValue: (key: string) => any };
	}) => React.ReactNode;
	className?: string;
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
	const [search, setSearch] = useState("");
	const debouncedSearch = useDebounce(search, 500);

	const initialPerPage =
		pagination?.meta?.per_page ||
		new URLSearchParams(window.location.search).get("per_page") ||
		"10";
	const [perPage, setPerPage] = useState(String(initialPerPage));

	useEffect(() => {
		if (searchEndpoint) {
			router.get(
				searchEndpoint,
				{ search: debouncedSearch, per_page: perPage, ...additionalParams },
				{
					preserveState: true,
					replace: true,
					preserveScroll: true,
				},
			);
		}
	}, [debouncedSearch, perPage]);

	return (
		<div className="space-y-4">
			<div className="flex items-center justify-between gap-4">
				{searchEndpoint && (
					<div className="flex items-center space-x-2 flex-1">
						<Search className="w-4 h-4 text-muted-foreground" />
						<Input
							placeholder={searchPlaceholder}
							value={search}
							onChange={(e) => setSearch(e.target.value)}
							className="h-8 w-[150px] lg:w-[250px]"
						/>
					</div>
				)}

				<div className="flex items-center gap-2">
					<span className="text-sm text-muted-foreground hidden sm:inline-block">
						Items per page:
					</span>
					<Select value={perPage} onValueChange={setPerPage}>
						<SelectTrigger className="h-8 w-[70px]">
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

			<div className="rounded-md border">
				<Table>
					<TableHeader>
						<TableRow>
							{columns.map((column, index) => (
								<TableHead key={index} className={column.className}>
									{column.header}
								</TableHead>
							))}
						</TableRow>
					</TableHeader>
					<TableBody>
						{data.length ? (
							data.map((row, rowIndex) => (
								<TableRow key={row.id || rowIndex}>
									{columns.map((column, colIndex) => {
										const cellValue = column.accessorKey
											? get(row, column.accessorKey)
											: null;
										const rowModel = {
											original: row,
											getValue: (key: string) => get(row, key),
										};
										return (
											<TableCell
												key={column.id || column.accessorKey || colIndex}
												className={column.className}
											>
												{column.cell
													? column.cell({ row: rowModel })
													: String(cellValue ?? "")}
											</TableCell>
										);
									})}
								</TableRow>
							))
						) : (
							<TableRow>
								<TableCell
									colSpan={columns.length}
									className="h-24 text-center"
								>
									No results.
								</TableCell>
							</TableRow>
						)}
					</TableBody>
				</Table>
			</div>

			{pagination && (
				<div className="flex items-center justify-end space-x-2 py-4">
					<InertiaPagination links={pagination.links} />
				</div>
			)}
		</div>
	);
}

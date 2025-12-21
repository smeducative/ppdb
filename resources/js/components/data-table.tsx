import { Input } from "@/components/ui/input";
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
}

export function DataTable<T extends { id?: number | string }>({
	columns,
	data,
	pagination,
	searchEndpoint,
	searchPlaceholder = "Search...",
	additionalParams = {},
}: DataTableProps<T>) {
	const [search, setSearch] = useState("");
	const debouncedSearch = useDebounce(search, 500);

	useEffect(() => {
		if (searchEndpoint) {
			router.get(
				searchEndpoint,
				{ search: debouncedSearch, ...additionalParams },
				{
					preserveState: true,
					replace: true,
					preserveScroll: true,
				},
			);
		}
	}, [debouncedSearch]);

	return (
		<div className="space-y-4">
			{searchEndpoint && (
				<div className="flex items-center space-x-2">
					<Search className="w-4 h-4 text-muted-foreground" />
					<Input
						placeholder={searchPlaceholder}
						value={search}
						onChange={(e) => setSearch(e.target.value)}
						className="h-8 w-[150px] lg:w-[250px]"
					/>
				</div>
			)}

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

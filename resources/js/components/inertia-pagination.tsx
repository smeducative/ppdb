import {
	Pagination,
	PaginationContent,
	PaginationEllipsis,
	PaginationItem,
	PaginationLink,
	PaginationNext,
	PaginationPrevious,
} from "@/components/ui/pagination";

interface Link {
	url: string | null;
	label: string;
	active: boolean;
}

interface Meta {
	links: Link[];
	from: number;
	to: number;
	total: number;
	per_page: number;
	current_page: number;
	last_page: number;
}

interface PaginationProps {
	links: Link[];
	meta?: Meta; // Sometimes Inertia returns meta separately
}

export function InertiaPagination({ links }: PaginationProps) {
	if (links.length <= 3) return null; // Hide if only Prev, 1, Next and 1 page

	return (
		<Pagination>
			<PaginationContent>
				{links.map((link, index) => {
					const isPrevious =
						link.label.includes("Previous") || link.label.includes("&laquo;");
					const isNext =
						link.label.includes("Next") || link.label.includes("&raquo;");

					if (isPrevious) {
						return (
							<PaginationItem key={index}>
								<PaginationPrevious
									href={link.url || "#"}
									isActive={!!link.url}
									className={!link.url ? "pointer-events-none opacity-50" : ""}
								/>
							</PaginationItem>
						);
					}

					if (isNext) {
						return (
							<PaginationItem key={index}>
								<PaginationNext
									href={link.url || "#"}
									isActive={!!link.url}
									className={!link.url ? "pointer-events-none opacity-50" : ""}
								/>
							</PaginationItem>
						);
					}

					if (link.label === "...") {
						return (
							<PaginationItem key={index}>
								<PaginationEllipsis />
							</PaginationItem>
						);
					}

					return (
						<PaginationItem key={index}>
							<PaginationLink href={link.url || "#"} isActive={link.active}>
								<span dangerouslySetInnerHTML={{ __html: link.label }} />
							</PaginationLink>
						</PaginationItem>
					);
				})}
			</PaginationContent>
		</Pagination>
	);
}

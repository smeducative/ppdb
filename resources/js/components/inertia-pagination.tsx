import { Link } from "@inertiajs/react";
import {
	ChevronLeftIcon,
	ChevronRightIcon,
	MoreHorizontalIcon,
} from "lucide-react";

import { buttonVariants } from "@/components/ui/button";
import { cn } from "@/lib/utils";

/**
 * Interface untuk link pagination dari Laravel
 */
interface PaginationLink {
	url: string | null;
	label: string;
	active: boolean;
}

interface InertiaPaginationProps {
	links: PaginationLink[];
}

/**
 * Komponen pagination yang terintegrasi dengan Inertia.js
 * Menggunakan Link dari Inertia untuk navigasi SPA tanpa reload
 */
export function InertiaPagination({ links }: InertiaPaginationProps) {
	// Sembunyikan jika hanya ada Prev, 1 halaman, Next
	if (links.length <= 3) return null;

	return (
		<nav
			role="navigation"
			aria-label="pagination"
			className="mx-auto flex w-full justify-center"
		>
			<ul className="flex flex-row items-center gap-1">
				{links.map((link, index) => {
					const isPrevious =
						link.label.includes("Previous") || link.label.includes("&laquo;");
					const isNext =
						link.label.includes("Next") || link.label.includes("&raquo;");

					// Tombol Previous
					if (isPrevious) {
						return (
							<li key={index}>
								{link.url ? (
									<Link
										href={link.url}
										preserveState
										preserveScroll
										aria-label="Halaman sebelumnya"
										className={cn(
											buttonVariants({ variant: "ghost", size: "default" }),
											"gap-1 px-2.5 sm:pl-2.5",
										)}
									>
										<ChevronLeftIcon className="size-4" />
										<span className="hidden sm:block">Sebelumnya</span>
									</Link>
								) : (
									<span
										className={cn(
											buttonVariants({ variant: "ghost", size: "default" }),
											"gap-1 px-2.5 sm:pl-2.5 pointer-events-none opacity-50",
										)}
									>
										<ChevronLeftIcon className="size-4" />
										<span className="hidden sm:block">Sebelumnya</span>
									</span>
								)}
							</li>
						);
					}

					// Tombol Next
					if (isNext) {
						return (
							<li key={index}>
								{link.url ? (
									<Link
										href={link.url}
										preserveState
										preserveScroll
										aria-label="Halaman selanjutnya"
										className={cn(
											buttonVariants({ variant: "ghost", size: "default" }),
											"gap-1 px-2.5 sm:pr-2.5",
										)}
									>
										<span className="hidden sm:block">Selanjutnya</span>
										<ChevronRightIcon className="size-4" />
									</Link>
								) : (
									<span
										className={cn(
											buttonVariants({ variant: "ghost", size: "default" }),
											"gap-1 px-2.5 sm:pr-2.5 pointer-events-none opacity-50",
										)}
									>
										<span className="hidden sm:block">Selanjutnya</span>
										<ChevronRightIcon className="size-4" />
									</span>
								)}
							</li>
						);
					}

					// Ellipsis
					if (link.label === "...") {
						return (
							<li key={index}>
								<span
									aria-hidden
									className="flex size-9 items-center justify-center"
								>
									<MoreHorizontalIcon className="size-4" />
									<span className="sr-only">Lebih banyak halaman</span>
								</span>
							</li>
						);
					}

					// Nomor halaman
					return (
						<li key={index}>
							{link.url ? (
								<Link
									href={link.url}
									preserveState
									preserveScroll
									aria-current={link.active ? "page" : undefined}
									className={cn(
										buttonVariants({
											variant: link.active ? "outline" : "ghost",
											size: "icon",
										}),
									)}
								>
									<span dangerouslySetInnerHTML={{ __html: link.label }} />
								</Link>
							) : (
								<span
									className={cn(
										buttonVariants({
											variant: link.active ? "outline" : "ghost",
											size: "icon",
										}),
									)}
								>
									<span dangerouslySetInnerHTML={{ __html: link.label }} />
								</span>
							)}
						</li>
					);
				})}
			</ul>
		</nav>
	);
}

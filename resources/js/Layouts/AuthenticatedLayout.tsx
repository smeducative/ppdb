import { AppSidebar } from "@/components/app-sidebar";
import { ModeToggle } from "@/components/mode-toggle";
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbList,
    BreadcrumbPage,
} from "@/components/ui/breadcrumb";
import { Separator } from "@/components/ui/separator";
import {
    SidebarInset,
    SidebarProvider,
    SidebarTrigger,
} from "@/components/ui/sidebar";
import { Toaster } from "@/components/ui/sonner";
import { usePage } from "@inertiajs/react";
import { type PropsWithChildren, useEffect } from "react";
import { toast } from "sonner";

interface AuthenticatedLayoutProps extends PropsWithChildren {
	header?: string;
}

export default function AuthenticatedLayout({
	header,
	children,
}: AuthenticatedLayoutProps) {
	const { flash } = usePage().props;

	useEffect(() => {
		if (flash?.success) {
			toast.success(flash.success);
		}
		if (flash?.error) {
			toast.error(flash.error);
		}
	}, [flash]);

	return (
		<SidebarProvider>
			<AppSidebar />

			<SidebarInset>
				<header className="flex h-16 shrink-0 items-center gap-2 border-b px-2 md:px-4">
					<SidebarTrigger className="-ml-1" />
					<Separator orientation="vertical" className="mr-2 h-4" />
					<Breadcrumb>
						<BreadcrumbList>
							<BreadcrumbItem>
								<BreadcrumbPage>{header ?? "Dashboard"}</BreadcrumbPage>
							</BreadcrumbItem>
						</BreadcrumbList>
					</Breadcrumb>
					{/* Theme Switcher - posisi di kanan */}
					<div className="ml-auto">
						<ModeToggle />
					</div>
				</header>
				<div className="flex flex-1 flex-col gap-4 p-4 md:p-4">{children}</div>

				<Toaster />
			</SidebarInset>
		</SidebarProvider>
	);
}

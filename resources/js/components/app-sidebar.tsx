"use client";

import { NavMain } from "@/components/nav-main";
import { NavUser } from "@/components/nav-user";
import {
	Sidebar,
	SidebarContent,
	SidebarFooter,
	SidebarHeader,
	SidebarMenu,
	SidebarMenuButton,
	SidebarMenuItem,
	SidebarRail,
} from "@/components/ui/sidebar";
import type { PageProps } from "@/types";
import { Link, usePage } from "@inertiajs/react";
import {
	Award,
	FileText,
	GraduationCap,
	LayoutDashboard,
	Receipt,
	Settings,
	Shirt,
	UserCheck,
	Users,
} from "lucide-react";

const navMain = [
	{
		title: "Dashboard",
		url: "/dashboard",
		icon: LayoutDashboard,
		isActive: true,
	},
	{
		title: "Pendaftar",
		url: "#",
		icon: Users,
		items: [
			{
				title: "Daftar Pendaftar",
				url: "/dashboard/ppdb/list-pendaftar",
			},
			{
				title: "Tambah Pendaftar",
				url: "/dashboard/ppdb/tambah-pendaftar",
			},
		],
	},
	{
		title: "Daftar Ulang",
		url: "#",
		icon: UserCheck,
		items: [
			{
				title: "Sudah Daftar Ulang",
				url: "/dashboard/ppdb/list/terdaftar-ulang",
			},
			{
				title: "Belum Daftar Ulang",
				url: "/dashboard/ppdb/list/belum-daftar-ulang",
			},
		],
	},
	{
		title: "Kwitansi",
		url: "#",
		icon: Receipt,
		items: [
			{
				title: "Daftar Kwitansi",
				url: "/dashboard/kwitansi/show",
			},
			{
				title: "Rekap Kwitansi",
				url: "/dashboard/kwitansi/rekap",
			},
		],
	},
	{
		title: "Dokumen",
		url: "#",
		icon: FileText,
		items: [
			{
				title: "Surat",
				url: "/dashboard/surat/show/TKJ",
			},
			{
				title: "Formulir",
				url: "/dashboard/formulir/show/TKJ",
			},
			{
				title: "Kartu Pendaftaran",
				url: "/dashboard/kartu-pendaftaran/show/TKJ",
			},
		],
	},
	{
		title: "Beasiswa",
		url: "#",
		icon: Award,
		items: [
			{
				title: "Rekomendasi MWC",
				url: "/dashboard/beasiswa/rekomendasi-mwc",
			},
			{
				title: "Akademik",
				url: "/dashboard/beasiswa/akademik",
			},
			{
				title: "Non Akademik",
				url: "/dashboard/beasiswa/non-akademik",
			},
			{
				title: "KIP",
				url: "/dashboard/beasiswa/kip",
			},
			{
				title: "Tahfidz",
				url: "/dashboard/beasiswa/tahfidz",
			},
		],
	},
	{
		title: "Ukuran Seragam",
		url: "/dashboard/ukuran-seragam/show",
		icon: Shirt,
	},
	{
		title: "Pengaturan",
		url: "#",
		icon: Settings,
		items: [
			{
				title: "Profil",
				url: "/dashboard/setting/profile",
			},
			{
				title: "PPDB",
				url: "/dashboard/setting/ppdb",
			},
		],
	},
];

export function AppSidebar({ ...props }: React.ComponentProps<typeof Sidebar>) {
	const { auth } = usePage<PageProps>().props;

	return (
		<Sidebar variant="sidebar" collapsible="icon" {...props}>
			<SidebarHeader>
				<SidebarMenu>
					<SidebarMenuItem>
						<SidebarMenuButton size="lg" asChild>
							<Link href="/dashboard">
								<div className="flex justify-center items-center bg-sidebar-primary rounded-lg size-8 aspect-square text-sidebar-primary-foreground">
									<GraduationCap className="size-4" />
								</div>
								<div className="flex-1 grid text-sm text-left leading-tight">
									<span className="font-semibold truncate">PPDB</span>
									<span className="text-xs truncate">Admin Panel</span>
								</div>
							</Link>
						</SidebarMenuButton>
					</SidebarMenuItem>
				</SidebarMenu>
			</SidebarHeader>
			<SidebarContent>
				<NavMain items={navMain} />
			</SidebarContent>
			<SidebarFooter>
				<NavUser
					user={{
						name: auth.user.name,
						email: auth.user.email,
						avatar: "",
					}}
				/>
			</SidebarFooter>
			<SidebarRail />
		</Sidebar>
	);
}

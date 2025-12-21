import {
	CreditCard,
	FileText,
	GraduationCap,
	LayoutDashboard,
	Settings2,
	Shirt,
	Users,
} from "lucide-react";
import type * as React from "react";

import { NavMain } from "@/components/nav-main";
import { NavUser } from "@/components/nav-user";
import { TeamSwitcher } from "@/components/team-switcher";
import {
	Sidebar,
	SidebarContent,
	SidebarFooter,
	SidebarHeader,
	SidebarRail,
} from "@/components/ui/sidebar";
import type { User } from "@/types";

// This is sample data.
const data = {
	teams: [
		{
			name: "SMK Diponegoro",
			logo: GraduationCap,
			plan: "PPDB",
		},
	],
	navMain: [
		{
			title: "Dashboard",
			url: "/dashboard",
			icon: LayoutDashboard,
			isActive: true,
		},
		{
			title: "Pendaftaran",
			url: "#",
			icon: Users,
			items: [
				{
					title: "List Pendaftar",
					url: "/dashboard/ppdb/list-pendaftar",
				},
				{
					title: "Tambah Pendaftar",
					url: "/dashboard/ppdb/tambah-pendaftar",
				},
				{
					title: "Daftar Ulang",
					url: "/dashboard/ppdb/list/terdaftar-ulang",
				},
				{
					title: "Belum Daftar Ulang",
					url: "/dashboard/ppdb/list/belum-daftar-ulang",
				},
			],
		},
		{
			title: "Keuangan",
			url: "#",
			icon: CreditCard,
			items: [
				{
					title: "Rekap Kwitansi",
					url: "/dashboard/kwitansi/rekap",
				},
			],
		},
		{
			title: "Logistik",
			url: "#",
			icon: Shirt,
			items: [
				{
					title: "Ukuran Seragam",
					url: "/dashboard/ukuran-seragam/show",
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
					url: "/dashboard/surat/show/1", // Default to TKJ or handle properly
				},
				{
					title: "Formulir",
					url: "/dashboard/formulir/show/1",
				},
				{
					title: "Kartu Pendaftaran",
					url: "/dashboard/kartu-pendaftaran/show/1",
				},
			],
		},
		{
			title: "Beasiswa",
			url: "#",
			icon: GraduationCap,
			items: [
				{
					title: "Rekomendasi MWC",
					url: "/dashboard/beasiswa/rekomendasi-mwc",
				},
				{ title: "Akademik", url: "/dashboard/beasiswa/akademik" },
				{ title: "Non Akademik", url: "/dashboard/beasiswa/non-akademik" },
				{ title: "KIP", url: "/dashboard/beasiswa/kip" },
				{ title: "Tahfidz", url: "/dashboard/beasiswa/tahfidz" },
			],
		},
		{
			title: "Settings",
			url: "#",
			icon: Settings2,
			items: [
				{
					title: "Profile",
					url: "/dashboard/setting/profile",
				},
				{
					title: "PPDB",
					url: "/dashboard/setting/ppdb",
				},
			],
		},
	],
};

export function AppSidebar({
	user,
	...props
}: React.ComponentProps<typeof Sidebar> & { user: User }) {
	return (
		<Sidebar collapsible="icon" {...props}>
			<SidebarHeader>
				<TeamSwitcher teams={data.teams} />
			</SidebarHeader>
			<SidebarContent>
				<NavMain items={data.navMain} />
			</SidebarContent>
			<SidebarFooter>
				<NavUser user={{ name: user.name, email: user.email, avatar: "" }} />
			</SidebarFooter>
			<SidebarRail />
		</Sidebar>
	);
}

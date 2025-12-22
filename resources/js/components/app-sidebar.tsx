import {
	Collapsible,
	CollapsibleContent,
	CollapsibleTrigger,
} from "@/components/ui/collapsible";
import {
	DropdownMenu,
	DropdownMenuContent,
	DropdownMenuItem,
	DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";
import {
	Sidebar,
	SidebarContent,
	SidebarFooter,
	SidebarGroup,
	SidebarGroupContent,
	SidebarGroupLabel,
	SidebarHeader,
	SidebarMenu,
	SidebarMenuButton,
	SidebarMenuItem,
	SidebarMenuSub,
	SidebarMenuSubButton,
	SidebarMenuSubItem,
} from "@/components/ui/sidebar";
import { Link, usePage } from "@inertiajs/react";
import {
	Award,
	Book,
	ChevronRight,
	ChevronUp,
	File,
	FileText,
	Gauge,
	IdCard,
	Medal,
	MonitorCog,
	Receipt,
	Settings,
	Shirt,
	Star,
	Trophy,
	User,
	UserCheck,
	UserPlus,
	UserX,
} from "lucide-react";

const jurusanItems = [
	{ id: 3, name: "AT" },
	{ id: 1, name: "TKJ" },
	{ id: 4, name: "BDP" },
	{ id: 6, name: "TSM" },
	{ id: 7, name: "TKR" },
];

export function AppSidebar() {
	const { url, props } = usePage();
	const user = props.auth?.user;

	const isActive = (path: string) => url.startsWith(path);

	return (
		<Sidebar collapsible="icon" variant="inset">
			<SidebarHeader>
				<SidebarMenu>
					<SidebarMenuItem>
						<SidebarMenuButton size="lg" asChild>
							<Link href="/">
								<div className="flex aspect-square size-8 items-center justify-center rounded-lg bg-primary text-primary-foreground">
									<img
										src="/img/logo.png"
										alt="Logo"
										className="size-6 rounded"
									/>
								</div>
								<div className="flex flex-col gap-0.5 leading-none">
									<span className="font-semibold">PPDB</span>
									<span className="text-xs">Admin Panel</span>
								</div>
							</Link>
						</SidebarMenuButton>
					</SidebarMenuItem>
				</SidebarMenu>
			</SidebarHeader>

			<SidebarContent>
				<SidebarGroup>
					<SidebarGroupContent>
						<SidebarMenu>
							{/* Dashboard */}
							<SidebarMenuItem>
								<SidebarMenuButton
									asChild
									isActive={url === "/dashboard" || url === "/dashboard/"}
								>
									<Link href={route("dashboard")}>
										<Gauge className="size-4" />
										<span>Dashboard</span>
									</Link>
								</SidebarMenuButton>
							</SidebarMenuItem>

							{/* Pendaftaran PPDB */}
							<CollapsibleMenuItem
								icon={<UserPlus className="size-4" />}
								title="Pendaftaran PPDB"
								defaultOpen={isActive("/dashboard/ppdb")}
							>
								<SidebarMenuSubItem>
									<SidebarMenuSubButton
										asChild
										isActive={url.includes("/ppdb/tambah-pendaftar")}
									>
										<Link href={route("ppdb.tambah.pendaftar")}>
											Tambah Peserta PPDB
										</Link>
									</SidebarMenuSubButton>
								</SidebarMenuSubItem>
								<SidebarMenuSubItem>
									<SidebarMenuSubButton
										asChild
										isActive={
											url === "/dashboard/ppdb/list-pendaftar" ||
											url === "/dashboard/ppdb/list-pendaftar/"
										}
									>
										<Link href={route("ppdb.list.pendaftar")}>
											List Semua Peserta
										</Link>
									</SidebarMenuSubButton>
								</SidebarMenuSubItem>
								{jurusanItems.map((jurusan) => (
									<SidebarMenuSubItem key={jurusan.id}>
										<SidebarMenuSubButton
											asChild
											isActive={url.includes(
												`/ppdb/list-pendaftar/${jurusan.id}`,
											)}
										>
											<Link
												href={route("ppdb.list.pendaftar.jurusan", {
													jurusan: jurusan.id,
												})}
											>
												{jurusan.name}
											</Link>
										</SidebarMenuSubButton>
									</SidebarMenuSubItem>
								))}
							</CollapsibleMenuItem>

							{/* List Daftar Ulang */}
							<CollapsibleMenuItem
								icon={<UserCheck className="size-4" />}
								title="List Daftar Ulang"
								defaultOpen={isActive("/dashboard/ppdb/list/terdaftar-ulang")}
							>
								<SidebarMenuSubItem>
									<SidebarMenuSubButton
										asChild
										isActive={
											url === "/dashboard/ppdb/list/terdaftar-ulang" ||
											url === "/dashboard/ppdb/list/terdaftar-ulang/"
										}
									>
										<Link href={route("ppdb.daftar.ulang.list")}>
											List Semua Peserta
										</Link>
									</SidebarMenuSubButton>
								</SidebarMenuSubItem>
								{jurusanItems.map((jurusan) => (
									<SidebarMenuSubItem key={jurusan.id}>
										<SidebarMenuSubButton
											asChild
											isActive={url.includes(
												`/ppdb/list/terdaftar-ulang/${jurusan.id}`,
											)}
										>
											<Link
												href={route("ppdb.daftar.ulang.list", {
													jurusan: jurusan.id,
												})}
											>
												DU {jurusan.name}
											</Link>
										</SidebarMenuSubButton>
									</SidebarMenuSubItem>
								))}
							</CollapsibleMenuItem>

							{/* List Belum Daftar Ulang */}
							<CollapsibleMenuItem
								icon={<UserX className="size-4" />}
								title="Belum Daftar Ulang"
								defaultOpen={isActive(
									"/dashboard/ppdb/list/belum-daftar-ulang",
								)}
							>
								<SidebarMenuSubItem>
									<SidebarMenuSubButton
										asChild
										isActive={
											url === "/dashboard/ppdb/list/belum-daftar-ulang" ||
											url === "/dashboard/ppdb/list/belum-daftar-ulang/"
										}
									>
										<Link href={route("ppdb.belum.daftar.ulang.list")}>
											List Semua Peserta
										</Link>
									</SidebarMenuSubButton>
								</SidebarMenuSubItem>
								{jurusanItems.map((jurusan) => (
									<SidebarMenuSubItem key={jurusan.id}>
										<SidebarMenuSubButton
											asChild
											isActive={url.includes(
												`/ppdb/list/belum-daftar-ulang/${jurusan.id}`,
											)}
										>
											<Link
												href={route("ppdb.belum.daftar.ulang.list", {
													jurusan: jurusan.id,
												})}
											>
												BDU {jurusan.name}
											</Link>
										</SidebarMenuSubButton>
									</SidebarMenuSubItem>
								))}
							</CollapsibleMenuItem>

							{/* Ukuran Baju */}
							<CollapsibleMenuItem
								icon={<Shirt className="size-4" />}
								title="List Ukuran Baju"
								defaultOpen={isActive("/dashboard/ukuran-seragam")}
							>
								<SidebarMenuSubItem>
									<SidebarMenuSubButton
										asChild
										isActive={
											url === "/dashboard/ukuran-seragam/show" ||
											url === "/dashboard/ukuran-seragam/show/"
										}
									>
										<Link href={route("ppdb.seragam.show.jurusan")}>
											List Semua Peserta
										</Link>
									</SidebarMenuSubButton>
								</SidebarMenuSubItem>
								{jurusanItems.map((jurusan) => (
									<SidebarMenuSubItem key={jurusan.id}>
										<SidebarMenuSubButton
											asChild
											isActive={url.includes(
												`/ukuran-seragam/show/${jurusan.id}`,
											)}
										>
											<Link
												href={route("ppdb.seragam.show.jurusan", {
													jurusan: jurusan.id,
												})}
											>
												{jurusan.name}
											</Link>
										</SidebarMenuSubButton>
									</SidebarMenuSubItem>
								))}
							</CollapsibleMenuItem>
						</SidebarMenu>
					</SidebarGroupContent>
				</SidebarGroup>

				{/* Cetak Dokumen */}
				<SidebarGroup>
					<SidebarGroupLabel>Cetak Dokumen</SidebarGroupLabel>
					<SidebarGroupContent>
						<SidebarMenu>
							{/* Kartu Pendaftaran */}
							<CollapsibleMenuItem
								icon={<IdCard className="size-4" />}
								title="Kartu Pendaftaran"
								defaultOpen={isActive("/dashboard/kartu-pendaftaran")}
							>
								{jurusanItems.map((jurusan) => (
									<SidebarMenuSubItem key={jurusan.id}>
										<SidebarMenuSubButton
											asChild
											isActive={url.includes(
												`/kartu-pendaftaran/show/${jurusan.id}`,
											)}
										>
											<Link
												href={route("ppdb.kartu.show.jurusan", {
													jurusan: jurusan.id,
												})}
											>
												Kartu {jurusan.name}
											</Link>
										</SidebarMenuSubButton>
									</SidebarMenuSubItem>
								))}
							</CollapsibleMenuItem>

							{/* Form Pendaftaran */}
							<CollapsibleMenuItem
								icon={<File className="size-4" />}
								title="Form Pendaftaran"
								defaultOpen={isActive("/dashboard/formulir")}
							>
								{jurusanItems.map((jurusan) => (
									<SidebarMenuSubItem key={jurusan.id}>
										<SidebarMenuSubButton
											asChild
											isActive={url.includes(`/formulir/show/${jurusan.id}`)}
										>
											<Link
												href={route("ppdb.formulir.show.jurusan", {
													jurusan: jurusan.id,
												})}
											>
												Form {jurusan.name}
											</Link>
										</SidebarMenuSubButton>
									</SidebarMenuSubItem>
								))}
							</CollapsibleMenuItem>

							{/* Surat Diterima */}
							<CollapsibleMenuItem
								icon={<FileText className="size-4" />}
								title="Surat Diterima"
								defaultOpen={isActive("/dashboard/surat")}
							>
								{jurusanItems.map((jurusan) => (
									<SidebarMenuSubItem key={jurusan.id}>
										<SidebarMenuSubButton
											asChild
											isActive={url.includes(`/surat/show/${jurusan.id}`)}
										>
											<Link
												href={route("ppdb.surat.show.jurusan", {
													jurusan: jurusan.id,
												})}
											>
												Surat {jurusan.name}
											</Link>
										</SidebarMenuSubButton>
									</SidebarMenuSubItem>
								))}
							</CollapsibleMenuItem>

							{/* Kwitansi */}
							<CollapsibleMenuItem
								icon={<Receipt className="size-4" />}
								title="Kwitansi"
								defaultOpen={isActive("/dashboard/kwitansi")}
							>
								<SidebarMenuSubItem>
									<SidebarMenuSubButton
										asChild
										isActive={
											url === "/dashboard/kwitansi/show" ||
											url === "/dashboard/kwitansi/show/"
										}
									>
										<Link href={route("ppdb.kwitansi.show")}>
											List Peserta Diterima
										</Link>
									</SidebarMenuSubButton>
								</SidebarMenuSubItem>
								{jurusanItems.map((jurusan) => (
									<SidebarMenuSubItem key={jurusan.id}>
										<SidebarMenuSubButton
											asChild
											isActive={url.includes(`/kwitansi/show/${jurusan.id}`)}
										>
											<Link
												href={route("ppdb.kwitansi.show.jurusan", {
													jurusan: jurusan.id,
												})}
											>
												Kwitansi {jurusan.name}
											</Link>
										</SidebarMenuSubButton>
									</SidebarMenuSubItem>
								))}
								<SidebarMenuSubItem>
									<SidebarMenuSubButton
										asChild
										isActive={url.includes("/kwitansi/rekap")}
									>
										<Link href={route("ppdb.rekap.kwitansi")}>
											Rekap Pembayaran
										</Link>
									</SidebarMenuSubButton>
								</SidebarMenuSubItem>
							</CollapsibleMenuItem>
						</SidebarMenu>
					</SidebarGroupContent>
				</SidebarGroup>

				{/* Beasiswa */}
				<SidebarGroup>
					<SidebarGroupLabel>Penerima Beasiswa</SidebarGroupLabel>
					<SidebarGroupContent>
						<SidebarMenu>
							<SidebarMenuItem>
								<SidebarMenuButton
									asChild
									isActive={url.includes("/beasiswa/mwc")}
								>
									<Link href={route("ppdb.beasiswa.mwc")}>
										<Award className="size-4" />
										<span>Rekomendasi MWC</span>
									</Link>
								</SidebarMenuButton>
							</SidebarMenuItem>
							<SidebarMenuItem>
								<SidebarMenuButton
									asChild
									isActive={url.includes("/beasiswa/akademik")}
								>
									<Link href={route("ppdb.beasiswa.akademik")}>
										<Trophy className="size-4" />
										<span>Akademik</span>
									</Link>
								</SidebarMenuButton>
							</SidebarMenuItem>
							<SidebarMenuItem>
								<SidebarMenuButton
									asChild
									isActive={url.includes("/beasiswa/tahfidz")}
								>
									<Link href={route("ppdb.beasiswa.tahfidz")}>
										<Book className="size-4" />
										<span>Akademik [Tahfidz]</span>
									</Link>
								</SidebarMenuButton>
							</SidebarMenuItem>
							<SidebarMenuItem>
								<SidebarMenuButton
									asChild
									isActive={url.includes("/beasiswa/non-akademik")}
								>
									<Link href={route("ppdb.beasiswa.non-akademik")}>
										<Star className="size-4" />
										<span>Non Akademik</span>
									</Link>
								</SidebarMenuButton>
							</SidebarMenuItem>
							<SidebarMenuItem>
								<SidebarMenuButton
									asChild
									isActive={url.includes("/beasiswa/kip")}
								>
									<Link href={route("ppdb.beasiswa.kip")}>
										<Medal className="size-4" />
										<span>KIP</span>
									</Link>
								</SidebarMenuButton>
							</SidebarMenuItem>
						</SidebarMenu>
					</SidebarGroupContent>
				</SidebarGroup>

				{/* Pengaturan */}
				<SidebarGroup>
					<SidebarGroupLabel>Pengaturan Akun</SidebarGroupLabel>
					<SidebarGroupContent>
						<SidebarMenu>
							<SidebarMenuItem>
								<SidebarMenuButton
									asChild
									isActive={url.includes("/setting/profile")}
								>
									<Link href={route("setting.profile")}>
										<User className="size-4" />
										<span>Pengaturan Profile</span>
									</Link>
								</SidebarMenuButton>
							</SidebarMenuItem>
							<SidebarMenuItem>
								<SidebarMenuButton
									asChild
									isActive={url.includes("/pengaturan-ppdb")}
								>
									<Link href={route("ppdb.set.batas.akhir")}>
										<Settings className="size-4" />
										<span>Pengaturan PPDB</span>
									</Link>
								</SidebarMenuButton>
							</SidebarMenuItem>
						</SidebarMenu>
					</SidebarGroupContent>
				</SidebarGroup>
			</SidebarContent>

			<SidebarFooter>
				<SidebarMenu>
					<SidebarMenuItem>
						<DropdownMenu>
							<DropdownMenuTrigger asChild>
								<SidebarMenuButton>
									<User className="size-4" />
									<span>{user?.name ?? "User"}</span>
									<ChevronUp className="ml-auto size-4" />
								</SidebarMenuButton>
							</DropdownMenuTrigger>
							<DropdownMenuContent
								side="top"
								className="w-[--radix-popper-anchor-width]"
							>
								<DropdownMenuItem asChild>
									<Link href={route("setting.profile")}>
										<User className="mr-2 size-4" />
										Profile
									</Link>
								</DropdownMenuItem>
								<DropdownMenuItem asChild>
									<Link href={route("logout")} method="post" as="button">
										<MonitorCog className="mr-2 size-4" />
										Logout
									</Link>
								</DropdownMenuItem>
							</DropdownMenuContent>
						</DropdownMenu>
					</SidebarMenuItem>
				</SidebarMenu>
			</SidebarFooter>
		</Sidebar>
	);
}

function CollapsibleMenuItem({
	icon,
	title,
	defaultOpen = false,
	children,
}: {
	icon: React.ReactNode;
	title: string;
	defaultOpen?: boolean;
	children: React.ReactNode;
}) {
	return (
		<Collapsible defaultOpen={defaultOpen} className="group/collapsible">
			<SidebarMenuItem>
				<CollapsibleTrigger asChild>
					<SidebarMenuButton>
						{icon}
						<span>{title}</span>
						<ChevronRight className="ml-auto size-4 transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
					</SidebarMenuButton>
				</CollapsibleTrigger>
				<CollapsibleContent>
					<SidebarMenuSub>{children}</SidebarMenuSub>
				</CollapsibleContent>
			</SidebarMenuItem>
		</Collapsible>
	);
}

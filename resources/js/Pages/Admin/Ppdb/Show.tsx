import { AlertMessages } from "@/components/alert-messages";
import {
	AlertDialog,
	AlertDialogAction,
	AlertDialogCancel,
	AlertDialogContent,
	AlertDialogDescription,
	AlertDialogFooter,
	AlertDialogHeader,
	AlertDialogTitle,
	AlertDialogTrigger,
} from "@/components/ui/alert-dialog";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import {
	Card,
	CardContent,
	CardDescription,
	CardFooter,
	CardHeader,
	CardTitle,
} from "@/components/ui/card";
import { formatDate } from "@/lib/date";
import { Head, Link, router, usePage } from "@inertiajs/react";
import {
	Award,
	BookOpen,
	CheckCircle2,
	ClipboardList,
	GraduationCap,
	Hash,
	Home,
	IdCard,
	MapPin,
	Medal,
	Pencil,
	Phone,
	School,
	ShieldCheck,
	Trophy,
	User,
	UserCircle,
	Users,
	XCircle,
} from "lucide-react";
import type { LucideIcon } from "lucide-react";
import type { ReactNode } from "react";

interface Jurusan {
	id: number;
	nama: string;
}

interface Peserta {
	id: string;
	no_pendaftaran: string;
	nama_lengkap: string;
	jenis_kelamin: string;
	tempat_lahir: string;
	tanggal_lahir: string;
	nik: string;
	alamat_lengkap: string;
	dukuh: string;
	rt: string;
	rw: string;
	desa_kelurahan: string;
	kecamatan: string;
	kabupaten_kota: string;
	provinsi: string;
	kode_pos: string;
	jurusan: Jurusan;
	asal_sekolah: string;
	tahun_lulus: string;
	nisn: string;
	penerima_kip: string;
	no_kip: string;
	no_hp: string;
	bertindik: boolean;
	bertato: boolean;
	nama_ayah: string;
	no_hp_ayah: string;
	pekerjaan_ayah: string;
	nama_ibu: string;
	no_hp_ibu: string;
	pekerjaan_ibu: string;
	akademik: {
		kelas?: string;
		semester?: string;
		peringkat?: string;
		hafidz?: string;
	} | null;
	non_akademik: {
		jenis_lomba?: string;
		juara_ke?: string;
		juara_tingkat?: string;
	} | null;
	rekomendasi_mwc: number;
	saran_dari: string;
	diterima: number;
}

interface Props {
	peserta: Peserta;
}

function StatusBadge({ status }: { status: number }) {
	switch (status) {
		case 1:
			return (
				<Badge className="bg-green-500 hover:bg-green-600">
					<CheckCircle2 className="size-3.5" />
					Diterima
				</Badge>
			);
		case 2:
			return (
				<Badge variant="destructive">
					<XCircle className="size-3.5" />
					Ditolak
				</Badge>
			);
		default:
			return (
				<Badge
					variant="secondary"
					className="border-yellow-500/20 bg-yellow-500/10 text-yellow-600 hover:bg-yellow-500/20 dark:text-yellow-400"
				>
					<ClipboardList className="size-3.5" />
					Proses Seleksi
				</Badge>
			);
	}
}

function InfoItem({
	icon: Icon,
	label,
	value,
}: {
	icon?: LucideIcon;
	label: string;
	value: ReactNode;
}) {
	return (
		<div className="flex min-w-0 gap-2.5 rounded-md border border-transparent bg-muted/40 px-3 py-2.5">
			{Icon ? (
				<div className="mt-0.5 shrink-0 text-muted-foreground">
					<Icon className="size-4" />
				</div>
			) : null}
			<div className="min-w-0 space-y-0.5">
				<p className="text-xs font-medium text-muted-foreground">{label}</p>
				<div className="truncate text-sm font-medium leading-snug break-words whitespace-normal">
					{value || "-"}
				</div>
			</div>
		</div>
	);
}

function SectionCard({
	icon: Icon,
	title,
	description,
	children,
	className,
}: {
	icon: LucideIcon;
	title: string;
	description?: string;
	children: ReactNode;
	className?: string;
}) {
	return (
		<Card className={className}>
			<CardHeader className="border-b pb-4">
				<div className="flex items-start gap-3">
					<div className="flex size-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
						<Icon className="size-4" />
					</div>
					<div className="min-w-0 space-y-1">
						<CardTitle className="text-base">{title}</CardTitle>
						{description ? (
							<CardDescription>{description}</CardDescription>
						) : null}
					</div>
				</div>
			</CardHeader>
			<CardContent className="pt-4">
				<div className="grid grid-cols-1 gap-2 sm:grid-cols-2">{children}</div>
			</CardContent>
		</Card>
	);
}

export default function Show({ peserta }: Props) {
	const { flash } = usePage<any>().props;

	const handleStatusChange = (status: "y" | "n") => {
		router.post(route("ppdb.terima.peserta", { uuid: peserta.id }), { status });
	};

	return (
		<>
			<Head title={peserta.nama_lengkap} />

			<div className="mx-auto max-w-7xl space-y-6">
				<AlertMessages flash={flash} />

				{/* Header */}
				<Card>
					<CardHeader className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
						<div className="flex min-w-0 items-start gap-3">
							<div className="flex size-12 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
								<UserCircle className="size-6" />
							</div>
							<div className="min-w-0 space-y-1.5">
								<div className="flex flex-wrap items-center gap-2">
									<CardTitle className="text-xl">
										{peserta.nama_lengkap}
									</CardTitle>
									<StatusBadge status={peserta.diterima} />
								</div>
								<div className="flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-muted-foreground">
									<span className="inline-flex items-center gap-1.5">
										<Hash className="size-3.5" />
										{peserta.no_pendaftaran}
									</span>
									<span className="inline-flex items-center gap-1.5">
										<GraduationCap className="size-3.5" />
										{peserta.jurusan?.nama || "-"}
									</span>
									<span className="inline-flex items-center gap-1.5">
										<School className="size-3.5" />
										{peserta.asal_sekolah || "-"}
									</span>
								</div>
							</div>
						</div>
						<Button asChild className="w-full sm:w-auto">
							<Link href={route("ppdb.edit.peserta", peserta.id)}>
								<Pencil className="size-4" />
								Edit
							</Link>
						</Button>
					</CardHeader>
				</Card>

				{/* Content grid */}
				<div className="grid grid-cols-1 gap-4 lg:grid-cols-2">
					<SectionCard
						icon={User}
						title="Identitas Diri"
						description="Data pribadi peserta"
					>
						<InfoItem
							icon={Hash}
							label="No. Pendaftaran"
							value={<strong>{peserta.no_pendaftaran}</strong>}
						/>
						<InfoItem
							icon={User}
							label="Nama Lengkap"
							value={peserta.nama_lengkap}
						/>
						<InfoItem
							icon={UserCircle}
							label="Jenis Kelamin"
							value={
								peserta.jenis_kelamin === "l" ? "Laki-laki" : "Perempuan"
							}
						/>
						<InfoItem
							icon={IdCard}
							label="Tempat, Tanggal Lahir"
							value={`${peserta.tempat_lahir}, ${formatDate(peserta.tanggal_lahir)}`}
						/>
						<InfoItem icon={IdCard} label="NIK" value={peserta.nik} />
						<InfoItem icon={IdCard} label="NISN" value={peserta.nisn} />
						<InfoItem
							icon={School}
							label="Asal Sekolah"
							value={peserta.asal_sekolah}
						/>
						<InfoItem
							icon={GraduationCap}
							label="Tahun Lulus"
							value={peserta.tahun_lulus}
						/>
						<InfoItem
							icon={BookOpen}
							label="Pilihan Jurusan"
							value={peserta.jurusan?.nama}
						/>
						<InfoItem icon={Phone} label="No. HP" value={peserta.no_hp} />
					</SectionCard>

					<SectionCard
						icon={MapPin}
						title="Alamat"
						description="Domisili peserta"
					>
						<InfoItem
							icon={Home}
							label="Alamat Jalan"
							value={peserta.alamat_lengkap}
						/>
						<InfoItem icon={MapPin} label="Dukuh" value={peserta.dukuh} />
						<InfoItem icon={Hash} label="RT" value={peserta.rt} />
						<InfoItem icon={Hash} label="RW" value={peserta.rw} />
						<InfoItem
							icon={MapPin}
							label="Desa/Kelurahan"
							value={peserta.desa_kelurahan}
						/>
						<InfoItem
							icon={MapPin}
							label="Kecamatan"
							value={peserta.kecamatan}
						/>
						<InfoItem
							icon={MapPin}
							label="Kabupaten/Kota"
							value={peserta.kabupaten_kota}
						/>
						<InfoItem
							icon={MapPin}
							label="Provinsi"
							value={peserta.provinsi}
						/>
						<InfoItem
							icon={Hash}
							label="Kode Pos"
							value={peserta.kode_pos}
						/>
					</SectionCard>

					<SectionCard
						icon={Users}
						title="Identitas Orang Tua"
						description="Data ayah dan ibu"
					>
						<InfoItem
							icon={User}
							label="Nama Ayah"
							value={peserta.nama_ayah}
						/>
						<InfoItem
							icon={ClipboardList}
							label="Pekerjaan Ayah"
							value={peserta.pekerjaan_ayah}
						/>
						<InfoItem
							icon={Phone}
							label="No. HP Ayah"
							value={peserta.no_hp_ayah}
						/>
						<InfoItem icon={User} label="Nama Ibu" value={peserta.nama_ibu} />
						<InfoItem
							icon={ClipboardList}
							label="Pekerjaan Ibu"
							value={peserta.pekerjaan_ibu}
						/>
						<InfoItem
							icon={Phone}
							label="No. HP Ibu"
							value={peserta.no_hp_ibu}
						/>
					</SectionCard>

					<SectionCard
						icon={ShieldCheck}
						title="KIP & Catatan"
						description="Bantuan dan catatan khusus"
					>
						<InfoItem
							icon={IdCard}
							label="Penerima KIP"
							value={
								peserta.penerima_kip === "y"
									? "Penerima KIP"
									: "Bukan penerima KIP"
							}
						/>
						<InfoItem icon={Hash} label="No. KIP" value={peserta.no_kip} />
						<InfoItem
							icon={ClipboardList}
							label="Bertindik"
							value={peserta.bertindik ? "Ya" : "Tidak"}
						/>
						<InfoItem
							icon={ClipboardList}
							label="Bertato"
							value={peserta.bertato ? "Ya" : "Tidak"}
						/>
					</SectionCard>

					<SectionCard
						icon={Award}
						title="Beasiswa Akademik"
						description="Prestasi akademik"
					>
						<InfoItem
							icon={BookOpen}
							label="Kelas"
							value={peserta.akademik?.kelas}
						/>
						<InfoItem
							icon={ClipboardList}
							label="Semester"
							value={peserta.akademik?.semester}
						/>
						<InfoItem
							icon={Medal}
							label="Peringkat"
							value={peserta.akademik?.peringkat}
						/>
						<InfoItem
							icon={Award}
							label="Hafidz / Hafidzoh"
							value={peserta.akademik?.hafidz}
						/>
					</SectionCard>

					<SectionCard
						icon={Trophy}
						title="Beasiswa Non Akademik"
						description="Prestasi lomba & rekomendasi"
					>
						<InfoItem
							icon={Trophy}
							label="Jenis Lomba"
							value={peserta.non_akademik?.jenis_lomba}
						/>
						<InfoItem
							icon={Medal}
							label="Juara Ke"
							value={peserta.non_akademik?.juara_ke}
						/>
						<InfoItem
							icon={Award}
							label="Juara Tingkat"
							value={peserta.non_akademik?.juara_tingkat}
						/>
						<InfoItem
							icon={ShieldCheck}
							label="Rekomendasi MWC"
							value={peserta.rekomendasi_mwc ? "Ya" : "Tidak"}
						/>
					</SectionCard>

					{/* Status + actions spans full width on large screens when alone, or sits in grid */}
					<Card className="lg:col-span-2">
						<CardHeader className="border-b pb-4">
							<div className="flex items-start gap-3">
								<div className="flex size-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
									<ClipboardList className="size-4" />
								</div>
								<div className="space-y-1">
									<CardTitle className="text-base">
										Status Penerimaan
									</CardTitle>
									<CardDescription>
										Kelola keputusan seleksi peserta
									</CardDescription>
								</div>
							</div>
						</CardHeader>
						<CardContent className="grid grid-cols-1 gap-2 pt-4 sm:grid-cols-2 lg:grid-cols-3">
							<InfoItem
								icon={CheckCircle2}
								label="Penerimaan"
								value={<StatusBadge status={peserta.diterima} />}
							/>
							<InfoItem
								icon={User}
								label="Saran Dari"
								value={peserta.saran_dari}
							/>
						</CardContent>
						<CardFooter className="flex flex-col items-stretch gap-4 border-t pt-4 sm:flex-row sm:items-center sm:justify-between">
							<p className="text-sm text-muted-foreground">
								Peserta yang dinyatakan diterima melakukan daftar ulang di menu
								kwitansi.
							</p>
							<div className="flex shrink-0 gap-2">
								<AlertDialog>
									<AlertDialogTrigger asChild>
										<Button className="bg-green-600 text-white hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800">
											<CheckCircle2 className="size-4" />
											Terima
										</Button>
									</AlertDialogTrigger>
									<AlertDialogContent>
										<AlertDialogHeader>
											<AlertDialogTitle>Terima Peserta?</AlertDialogTitle>
											<AlertDialogDescription>
												Apakah Anda yakin ingin menerima peserta ini?
											</AlertDialogDescription>
										</AlertDialogHeader>
										<AlertDialogFooter>
											<AlertDialogCancel>Batal</AlertDialogCancel>
											<AlertDialogAction
												onClick={() => handleStatusChange("y")}
												className="bg-green-600 text-white hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800"
											>
												Terima
											</AlertDialogAction>
										</AlertDialogFooter>
									</AlertDialogContent>
								</AlertDialog>

								<AlertDialog>
									<AlertDialogTrigger asChild>
										<Button variant="destructive">
											<XCircle className="size-4" />
											Tolak
										</Button>
									</AlertDialogTrigger>
									<AlertDialogContent>
										<AlertDialogHeader>
											<AlertDialogTitle>Tolak Peserta?</AlertDialogTitle>
											<AlertDialogDescription>
												Apakah Anda yakin ingin menolak peserta ini?
											</AlertDialogDescription>
										</AlertDialogHeader>
										<AlertDialogFooter>
											<AlertDialogCancel>Batal</AlertDialogCancel>
											<AlertDialogAction
												onClick={() => handleStatusChange("n")}
												className="bg-red-600 hover:bg-red-700"
											>
												Tolak
											</AlertDialogAction>
										</AlertDialogFooter>
									</AlertDialogContent>
								</AlertDialog>
							</div>
						</CardFooter>
					</Card>
				</div>
			</div>
		</>
	);
}

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
	CardFooter,
	CardHeader,
	CardTitle,
} from "@/components/ui/card";
import { Separator } from "@/components/ui/separator";
import { formatDate } from "@/lib/date";
import { Head, Link, router, usePage } from "@inertiajs/react";

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
	penerima_kip: string; // 'y' or 'n' or null
	no_kip: string;
	no_hp: string;
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
	rekomendasi_mwc: number; // boolean like
	saran_dari: string;
	diterima: number;
}

interface Props {
	peserta: Peserta;
}

export default function Show({ peserta }: Props) {
	const { flash } = usePage<any>().props;

	const handleStatusChange = (status: "y" | "n") => {
		router.post(route("ppdb.terima.peserta", { uuid: peserta.id }), { status });
	};

	const StatusBadge = ({ status }: { status: number }) => {
		switch (status) {
			case 1:
				return (
					<Badge className="bg-green-500 hover:bg-green-600">Diterima</Badge>
				);
			case 2:
				return <Badge variant="destructive">Ditolak</Badge>;
			default:
				return (
					<Badge
						variant="secondary"
						className="bg-yellow-500/10 text-yellow-600 border-yellow-500/20 hover:bg-yellow-500/20 dark:text-yellow-400"
					>
						Proses Seleksi
					</Badge>
				);
		}
	};

	const InfoRow = ({
		label,
		value,
	}: {
		label: string;
		value: React.ReactNode;
	}) => (
		<div className="grid grid-cols-1 md:grid-cols-3 py-2 border-b last:border-0">
			<div className="font-medium text-muted-foreground">{label}</div>
			<div className="md:col-span-2">{value || "-"}</div>
		</div>
	);

	return (
		<>
			<Head title={peserta.nama_lengkap} />

			<div className="max-w-4xl mx-auto space-y-6">
				<AlertMessages flash={flash} />

				<Card>
					<CardHeader className="flex flex-row items-center justify-between">
						<CardTitle>Data Diri Peserta</CardTitle>
						<Button asChild>
							<Link href={route("ppdb.edit.peserta", peserta.id)}>Edit</Link>
						</Button>
					</CardHeader>
					<CardContent className="space-y-6">
						<div>
							<h3 className="text-lg font-semibold mb-3"># Identitas Diri</h3>
							<InfoRow
								label="No. Pendaftaran"
								value={<strong>{peserta.no_pendaftaran}</strong>}
							/>
							<InfoRow label="Nama Lengkap" value={peserta.nama_lengkap} />
							<InfoRow
								label="Jenis Kelamin"
								value={
									peserta.jenis_kelamin === "l" ? "Laki-laki" : "Perempuan"
								}
							/>
							<InfoRow
								label="Tempat, Tanggal Lahir"
								value={`${peserta.tempat_lahir}, ${formatDate(peserta.tanggal_lahir)}`}
							/>
							<InfoRow label="Asal Sekolah" value={peserta.asal_sekolah} />
							<InfoRow label="Tahun Lulus" value={peserta.tahun_lulus} />
							<InfoRow label="Pilihan Jurusan" value={peserta.jurusan?.nama} />
							<InfoRow label="NIK" value={peserta.nik} />
							<InfoRow label="NISN" value={peserta.nisn} />
							<InfoRow label="Alamat" value={peserta.alamat_lengkap} />
							<InfoRow label="Dukuh" value={peserta.dukuh} />
							<InfoRow label="RT" value={peserta.rt} />
							<InfoRow label="RW" value={peserta.rw} />
							<InfoRow label="Desa/Kelurahan" value={peserta.desa_kelurahan} />
							<InfoRow label="Kecamatan" value={peserta.kecamatan} />
							<InfoRow label="Kabupaten/Kota" value={peserta.kabupaten_kota} />
							<InfoRow label="Provinsi" value={peserta.provinsi} />
							<InfoRow label="Kode Pos" value={peserta.kode_pos} />
							<InfoRow label="No. HP" value={peserta.no_hp} />
							<InfoRow
								label="Penerima KIP"
								value={
									peserta.penerima_kip === "y"
										? "Penerima KIP"
										: "Bukan penerima KIP"
								}
							/>
							<InfoRow label="No. KIP" value={peserta.no_kip} />
						</div>

						<Separator />

						<div>
							<h3 className="text-lg font-semibold mb-3">
								# Identitas Orang Tua
							</h3>
							<InfoRow label="Nama Ayah" value={peserta.nama_ayah} />
							<InfoRow label="Pekerjaan Ayah" value={peserta.pekerjaan_ayah} />
							<InfoRow label="No. HP Ayah" value={peserta.no_hp_ayah} />
							<InfoRow label="Nama Ibu" value={peserta.nama_ibu} />
							<InfoRow label="Pekerjaan Ibu" value={peserta.pekerjaan_ibu} />
							<InfoRow label="No. HP Ibu" value={peserta.no_hp_ibu} />
						</div>

						<Separator />

						<div>
							<h3 className="text-lg font-semibold mb-3"># Jenis Beasiswa</h3>
							<h4 className="font-medium text-muted-foreground mt-2 mb-1">
								Akademik
							</h4>
							<InfoRow label="Kelas" value={peserta.akademik?.kelas} />
							<InfoRow label="Semester" value={peserta.akademik?.semester} />
							<InfoRow label="Peringkat" value={peserta.akademik?.peringkat} />
							<InfoRow
								label="Hafidz / Hafidzoh"
								value={peserta.akademik?.hafidz}
							/>

							<h4 className="font-medium text-muted-foreground mt-4 mb-1">
								Non Akademik
							</h4>
							<InfoRow
								label="Jenis Lomba"
								value={peserta.non_akademik?.jenis_lomba}
							/>
							<InfoRow
								label="Juara Ke"
								value={peserta.non_akademik?.juara_ke}
							/>
							<InfoRow
								label="Juara Tingkat"
								value={peserta.non_akademik?.juara_tingkat}
							/>

							<h4 className="font-medium text-muted-foreground mt-4 mb-1">
								Rekomendasi
							</h4>
							<InfoRow
								label="Rekomendasi MWC"
								value={peserta.rekomendasi_mwc ? "Ya" : "Tidak"}
							/>
						</div>

						<Separator />

						<div>
							<h3 className="text-lg font-semibold mb-3"># Status</h3>
							<InfoRow
								label="Penerimaan"
								value={<StatusBadge status={peserta.diterima} />}
							/>
							<InfoRow label="Saran Dari" value={peserta.saran_dari} />
						</div>
					</CardContent>
					<CardFooter className="flex flex-col items-start gap-4">
						<p className="text-sm text-muted-foreground">
							Peserta yang dinyatakan diterima, melakukan daftar ulang di menu
							kwitansi.
						</p>
						<div className="flex gap-2">
							<AlertDialog>
								<AlertDialogTrigger asChild>
									<Button className="bg-green-600 hover:bg-green-700 text-white dark:bg-green-700 dark:hover:bg-green-800">
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
											className="bg-green-600 hover:bg-green-700 text-white dark:bg-green-700 dark:hover:bg-green-800"
										>
											Terima
										</AlertDialogAction>
									</AlertDialogFooter>
								</AlertDialogContent>
							</AlertDialog>

							<AlertDialog>
								<AlertDialogTrigger asChild>
									<Button variant="destructive">Tolak</Button>
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
		</>
	);
}

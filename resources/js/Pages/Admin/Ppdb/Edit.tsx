import { RegistrationForm } from "@/components/registration-form";
import { Head, router } from "@inertiajs/react";
import { format } from "date-fns";

interface Jurusan {
	id: number;
	nama: string;
}

interface Peserta {
	id: number;
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
	jurusan_id: number;
	asal_sekolah: string;
	tahun_lulus: string;
	nisn: string;
	penerima_kip: string; // 'y' or 'n' or null
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
	rekomendasi_mwc: number; // boolean like
	saran_dari: string;
}

interface Props {
	jurusan: Jurusan[];
	peserta: Peserta;
}

export default function Edit({ jurusan, peserta }: Props) {
	const jurusanOptions = jurusan.map((j) => ({
		value: String(j.id),
		label: j.nama,
	}));

	const initialData = {
		nama_lengkap: peserta.nama_lengkap || "",
		jenis_kelamin: peserta.jenis_kelamin || "",
		tempat_lahir: peserta.tempat_lahir || "",
		tanggal_lahir: peserta.tanggal_lahir
			? format(new Date(peserta.tanggal_lahir), "yyyy-MM-dd")
			: "",
		nik: peserta.nik || "",
		nisn: peserta.nisn || "",
		alamat_lengkap: peserta.alamat_lengkap || "",
		dukuh: peserta.dukuh || "",
		rt: peserta.rt || "",
		rw: peserta.rw || "",
		desa_kelurahan: peserta.desa_kelurahan || "",
		kecamatan: peserta.kecamatan || "",
		kabupaten_kota: peserta.kabupaten_kota || "",
		provinsi: peserta.provinsi || "",
		kode_pos: peserta.kode_pos || "",
		pilihan_jurusan: String(peserta.jurusan_id || ""),
		asal_sekolah: peserta.asal_sekolah || "",
		tahun_lulus: peserta.tahun_lulus || "",
		penerima_kip: peserta.penerima_kip === "y",
		no_kip: peserta.no_kip || "",
		no_hp: peserta.no_hp || "",
		bertindik: !!peserta.bertindik,
		bertato: !!peserta.bertato,

		// Data Orang Tua
		nama_ayah: peserta.nama_ayah || "",
		no_ayah: peserta.no_hp_ayah || "",
		pekerjaan_ayah: peserta.pekerjaan_ayah || "",
		nama_ibu: peserta.nama_ibu || "",
		no_ibu: peserta.no_hp_ibu || "",
		pekerjaan_ibu: peserta.pekerjaan_ibu || "",

		// Prestasi
		peringkat:
			peserta.akademik?.kelas &&
			peserta.akademik?.semester &&
			peserta.akademik?.peringkat
				? `${peserta.akademik.kelas}/${peserta.akademik.semester}/${peserta.akademik.peringkat}`
				: "",
		hafidz: peserta.akademik?.hafidz || "",
		jenis_lomba: peserta.non_akademik?.jenis_lomba || "",
		juara_ke: peserta.non_akademik?.juara_ke || "",
		juara_tingkat: peserta.non_akademik?.juara_tingkat || "",

		// Rekomendasi
		rekomendasi_mwc: !!peserta.rekomendasi_mwc,
		saran_dari: peserta.saran_dari || "",
	};

	const handleDelete = () => {
		router.delete(route("ppdb.delete.peserta", peserta.id));
	};

	return (
		<>
			<Head title="Edit Peserta SPMB" />

			<div className="mx-auto space-y-6 max-w-5xl">
				<RegistrationForm
					mode="admin"
					method="put"
					initialData={initialData}
					jurusanOptions={jurusanOptions}
					submitUrl={route("ppdb.edit.peserta", peserta.id)}
					showDelete={true}
					onDelete={handleDelete}
					title="Edit Data Pendaftar"
					description={`Mengedit data pendaftar: ${peserta.nama_lengkap}`}
				/>
			</div>
		</>
	);
}

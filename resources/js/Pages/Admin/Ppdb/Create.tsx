import { RegistrationForm } from "@/components/registration-form";
import { Head } from "@inertiajs/react";

interface Jurusan {
	id: number;
	nama: string;
}

interface Props {
	jurusan: Jurusan[];
}

export default function Create({ jurusan }: Props) {
	const jurusanOptions = jurusan.map((j) => ({
		value: String(j.id),
		label: j.nama,
	}));

	return (
		<>
			<Head title="Tambah Peserta SPMB" />

			<div className="mx-auto space-y-6 max-w-5xl">
				<RegistrationForm
					mode="admin"
					jurusanOptions={jurusanOptions}
					submitUrl={route("ppdb.tambah.pendaftar")}
					title="Tambah Pendaftar Baru"
					description="Silahkan isi formulir pendaftaran peserta didik baru"
				/>
			</div>
		</>
	);
}

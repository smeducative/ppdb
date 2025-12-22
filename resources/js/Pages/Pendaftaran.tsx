import { Footer } from "@/components/footer";
import { Navbar } from "@/components/navbar";
import { RegistrationForm } from "@/components/registration-form";
import { Head } from "@inertiajs/react";

interface PendaftaranPageProps {
	jurusan: { value: number | string; label: string }[];
}

export default function PendaftaranPage({ jurusan }: PendaftaranPageProps) {
	return (
		<>
			<Head title="Formulir Pendaftaran | SPMB SMK Diponegoro Karanganyar" />
			<Navbar />
			<main className="min-h-screen bg-gradient-to-b from-secondary via-background to-accent pt-24 pb-16">
				<RegistrationForm jurusanOptions={jurusan} />
			</main>
			<Footer />
		</>
	);
}

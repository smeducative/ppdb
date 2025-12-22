import { CTASection } from "@/components/cta-section";
import { ExtracurricularSection } from "@/components/extracurricular-section";
import { FacilitiesSection } from "@/components/facilities-section";
import { Footer } from "@/components/footer";
import { HeroSection } from "@/components/hero-section";
import { Navbar } from "@/components/navbar";
import { ProgramsSection } from "@/components/programs-section";
import { RegistrationFlow } from "@/components/registration-flow";
import { ScholarshipSection } from "@/components/scholarship-section";
import { Head } from "@inertiajs/react";

export default function Home() {
	return (
		<main className="min-h-screen">
			<Head title="SPMB SMK Diponegoro Karanganyar | Pendaftaran Siswa Baru 2025/2026" />
			<Navbar />
			<HeroSection />
			<RegistrationFlow />
			<ProgramsSection />
			<FacilitiesSection />
			<ScholarshipSection />
			<ExtracurricularSection />
			<CTASection />
			<Footer />
		</main>
	);
}

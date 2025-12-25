import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { Building, ClipboardList, CreditCard, FileText } from "lucide-react";
import { useEffect, useRef } from "react";

gsap.registerPlugin(ScrollTrigger);

const steps = [
	{
		icon: ClipboardList,
		title: "Daftar Online / Offline",
		description:
			"Calon Peserta Didik baru dapat mendaftar secara mandiri melalui website SPMB Online atau datang langsung ke SMK Diponegoro Karanganyar.",
	},
	{
		icon: FileText,
		title: "Siapkan Berkas",
		description:
			"Siapkan foto 3x4 (2 lembar), FC KK, FC Akte Kelahiran, FC KIP (jika ada), FC Ijazah/SKL, FC Raport/Piagam prestasi.",
	},
	{
		icon: CreditCard,
		title: "Daftar Ulang",
		description:
			"Setelah dinyatakan diterima, peserta SPMB membayar biaya daftar ulang sebesar Rp. 250.000,-",
	},
	{
		icon: Building,
		title: "Serahkan Berkas",
		description:
			"Berkas Pendaftaran dan Biaya Daftar Ulang diserahkan langsung ke SMK Diponegoro Karanganyar.",
	},
];

export function RegistrationFlow() {
	const sectionRef = useRef<HTMLElement>(null);
	const titleRef = useRef<HTMLDivElement>(null);
	const stepsRef = useRef<(HTMLDivElement | null)[]>([]);
	const lineRef = useRef<HTMLDivElement>(null);

	useEffect(() => {
		const ctx = gsap.context(() => {
			gsap.fromTo(
				titleRef.current,
				{ opacity: 0, y: 50 },
				{
					opacity: 1,
					y: 0,
					duration: 0.8,
					scrollTrigger: {
						trigger: titleRef.current,
						start: "top 80%",
					},
				},
			);

			gsap.fromTo(
				lineRef.current,
				{ scaleX: 0 },
				{
					scaleX: 1,
					duration: 1.5,
					ease: "power2.inOut",
					scrollTrigger: {
						trigger: sectionRef.current,
						start: "top 60%",
					},
				},
			);

			stepsRef.current.forEach((step, index) => {
				if (step) {
					gsap.fromTo(
						step,
						{ opacity: 0, y: 60, scale: 0.9 },
						{
							opacity: 1,
							y: 0,
							scale: 1,
							duration: 0.6,
							delay: index * 0.15,
							scrollTrigger: {
								trigger: step,
								start: "top 85%",
							},
						},
					);
				}
			});
		}, sectionRef);

		return () => ctx.revert();
	}, []);

	return (
		<section
			ref={sectionRef}
			id="alur"
			className="py-24 md:py-32 bg-background relative overflow-hidden"
		>
			<div className="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-background to-transparent" />

			<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div ref={titleRef} className="text-center mb-20">
					<span className="inline-block px-4 py-2 bg-primary/10 text-primary text-sm font-semibold rounded-full mb-4">
						Langkah Mudah
					</span>
					<h2 className="text-4xl md:text-5xl font-bold text-foreground mb-6">
						Alur Pendaftaran
					</h2>
					<p className="text-muted-foreground text-lg max-w-2xl mx-auto">
						Proses pendaftaran yang mudah dan transparan. Ikuti langkah-langkah
						berikut untuk menjadi bagian dari SMK Diponegoro Karanganyar.
					</p>
				</div>

				<div className="relative">
					<div
						ref={lineRef}
						className="hidden md:block absolute top-10 left-[10%] right-[10%] h-1 bg-gradient-to-r from-primary/20 via-primary to-primary/20 rounded-full origin-left"
					/>

					<div className="grid md:grid-cols-4 gap-8 md:gap-6">
						{steps.map((step, index) => (
							<div
								key={step.title}
								ref={(el) => {
									stepsRef.current[index] = el;
								}}
								className="relative flex flex-col items-center text-center group"
							>
								<div className="absolute -top-3 left-1/2 -translate-x-1/2 w-8 h-8 bg-background border-2 border-primary rounded-full flex items-center justify-center text-sm font-bold text-primary z-20 shadow-lg">
									{index + 1}
								</div>

								<div className="w-20 h-20 bg-primary rounded-2xl flex items-center justify-center mb-6 relative z-10 shadow-xl shadow-primary/20 group-hover:scale-110 group-hover:shadow-2xl group-hover:shadow-primary/30 transition-all duration-300">
									<step.icon className="w-9 h-9 text-primary-foreground" />
								</div>

								<h3 className="font-bold text-foreground text-lg mb-3">
									{step.title}
								</h3>
								<p className="text-sm text-muted-foreground leading-relaxed">
									{step.description}
								</p>
							</div>
						))}
					</div>
				</div>
			</div>
		</section>
	);
}

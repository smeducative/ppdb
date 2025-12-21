"use client";

import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { Car, Film, Leaf, Monitor, Wrench } from "lucide-react";
import { useEffect, useRef } from "react";

gsap.registerPlugin(ScrollTrigger);

const programs = [
	{
		icon: Monitor,
		title: "Teknik Jaringan Komputer dan Telekomunikasi",
		shortName: "TJKT",
		description:
			"Program keahlian di bidang Teknologi Informasi yang mempelajari perakitan komputer, instalasi jaringan, dan telekomunikasi modern.",
		skills: [
			"Instalasi Jaringan LAN/WAN",
			"Administrasi Server",
			"Troubleshooting Hardware",
			"Telekomunikasi",
		],
		prospects: [
			"IT Support",
			"Network Administrator",
			"Teknisi Telekomunikasi",
		],
		gradient: "from-emerald-500 to-teal-600",
	},
	{
		icon: Car,
		title: "Teknik Kendaraan Ringan",
		shortName: "TKR",
		description:
			"Program keahlian yang mempelajari perawatan dan perbaikan kendaraan ringan (mobil) dengan standar industri otomotif.",
		skills: [
			"Perawatan Mesin Mobil",
			"Sistem Kelistrikan",
			"Tune Up & Overhaul",
			"Sistem Injeksi",
		],
		prospects: ["Mekanik Dealer", "Teknisi Bengkel", "Wirausaha Otomotif"],
		gradient: "from-blue-500 to-indigo-600",
	},
	{
		icon: Wrench,
		title: "Teknik Sepeda Motor",
		shortName: "TSM",
		description:
			"Program keahlian yang mempelajari perawatan dan perbaikan sepeda motor dengan standar industri.",
		skills: [
			"Perawatan Mesin Motor",
			"Sistem Kelistrikan",
			"Tune Up & Overhaul",
			"Injeksi & Karburator",
		],
		prospects: ["Mekanik Bengkel", "Teknisi Dealer", "Wirausaha Bengkel"],
		gradient: "from-orange-500 to-red-600",
	},
	{
		icon: Film,
		title: "Broadcasting dan Perfilman",
		shortName: "BDP",
		description:
			"Program keahlian yang mempelajari teknik penyiaran, produksi video, dan perfilman dengan peralatan modern.",
		skills: [
			"Produksi Video",
			"Editing Film",
			"Teknik Penyiaran",
			"Sinematografi",
		],
		prospects: ["Video Editor", "Kameramen", "Content Creator", "Broadcasting"],
		gradient: "from-purple-500 to-pink-600",
	},
	{
		icon: Leaf,
		title: "Agribisnis Tanaman (Smart Farming)",
		shortName: "AT",
		description:
			"Program keahlian yang mempelajari budidaya tanaman dengan teknologi pertanian modern. Dapatkan subsidi SPP 50% selama 3 tahun!",
		skills: [
			"Budidaya Tanaman",
			"Smart Farming",
			"Teknologi Pertanian",
			"Agribisnis",
		],
		prospects: ["Petani Modern", "Agripreneur", "Teknisi Pertanian"],
		gradient: "from-green-500 to-emerald-600",
		badge: "Subsidi SPP 50%",
	},
];

export function ProgramsSection() {
	const sectionRef = useRef<HTMLElement>(null);
	const titleRef = useRef<HTMLDivElement>(null);
	const cardsRef = useRef<(HTMLDivElement | null)[]>([]);

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

			cardsRef.current.forEach((card, index) => {
				if (card) {
					gsap.fromTo(
						card,
						{ opacity: 0, y: 80, rotateY: -15 },
						{
							opacity: 1,
							y: 0,
							rotateY: 0,
							duration: 0.8,
							delay: index * 0.15,
							ease: "power3.out",
							scrollTrigger: {
								trigger: card,
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
			id="jurusan"
			className="py-24 md:py-32 bg-secondary/30 relative overflow-hidden"
		>
			<div className="absolute top-20 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl" />
			<div className="absolute bottom-20 left-0 w-80 h-80 bg-primary/5 rounded-full blur-3xl" />

			<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
				<div ref={titleRef} className="text-center mb-16">
					<span className="inline-block px-4 py-2 bg-primary/10 text-primary text-sm font-semibold rounded-full mb-4">
						Pilih Minatmu
					</span>
					<h2 className="text-4xl md:text-5xl font-bold text-foreground mb-6">
						Program Keahlian
					</h2>
					<p className="text-muted-foreground text-lg max-w-2xl mx-auto">
						Banyak pilihan program keahlian yang dapat dipilih sesuai dengan
						minat dan bakat siswa.
					</p>
				</div>

				<div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
					{programs.map((program, index) => (
						<div
							key={program.title}
							ref={(el) => {
								cardsRef.current[index] = el;
							}}
							className="group bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2"
							style={{ perspective: "1000px" }}
						>
							<div className={`h-2 bg-linear-to-r ${program.gradient}`} />

							<div className="p-6">
								<div className="flex items-start justify-between mb-4">
									<div
										className={`w-14 h-14 bg-gradient-to-br ${program.gradient} rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300`}
									>
										<program.icon className="w-7 h-7 text-white" />
									</div>
									{program.badge && (
										<span className="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
											{program.badge}
										</span>
									)}
								</div>

								<span className="inline-block px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full mb-3">
									{program.shortName}
								</span>

								<h3 className="text-lg font-bold text-foreground mb-2 group-hover:text-primary transition-colors leading-tight">
									{program.title}
								</h3>

								<p className="text-muted-foreground text-sm mb-4 leading-relaxed">
									{program.description}
								</p>

								<div className="space-y-3">
									<div>
										<p className="text-xs font-semibold text-foreground mb-2">
											Kompetensi:
										</p>
										<ul className="space-y-1">
											{program.skills.slice(0, 3).map((skill, i) => (
												<li
													key={i}
													className="text-xs text-muted-foreground flex items-center gap-2"
												>
													<span className="w-1.5 h-1.5 bg-primary rounded-full shrink-0" />
													{skill}
												</li>
											))}
										</ul>
									</div>

									<div>
										<p className="text-xs font-semibold text-foreground mb-2">
											Prospek Karir:
										</p>
										<div className="flex flex-wrap gap-1.5">
											{program.prospects.slice(0, 3).map((prospect, i) => (
												<span
													key={i}
													className="px-2 py-1 bg-secondary text-secondary-foreground text-xs font-medium rounded-full"
												>
													{prospect}
												</span>
											))}
										</div>
									</div>
								</div>
							</div>
						</div>
					))}
				</div>

				{/* <div className="text-center mt-12">
					<Button
						size="lg"
						variant="outline"
						className="rounded-full px-8 hover:scale-105 transition-all duration-300 bg-transparent"
						asChild
					>
						<Link href="/pendaftaran" className="gap-2">
							Pilih Jurusan & Daftar
							<ArrowRight className="w-4 h-4" />
						</Link>
					</Button>
				</div> */}
			</div>
		</section>
	);
}

"use client";

import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { Car, Cpu, Film, Leaf, Monitor, Wrench } from "lucide-react";
import { useEffect, useRef } from "react";
import { MagicBento } from "./magic-bento";

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
		colSpan: 2,
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
		colSpan: 1,
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
		colSpan: 1,
	},
	{
		icon: Film,
		title: "Broadcasting dan Perfilman",
		shortName: "BCF",
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
		colSpan: 2,
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
		colSpan: 1,
	},
	{
		icon: Cpu,
		title: "Axioo Class Program (TJKT)",
		shortName: "ACP",
		description:
			"Program kelas industri yang bekerjasama dengan Axioo untuk mencetak tenaga ahli di bidang teknologi informasi dan komputer.",
		skills: [
			"Perakitan Komputer",
			"Jaringan Komputer",
			"Pemrograman Web",
			"Desain Grafis",
		],
		prospects: ["IT Support", "Web Developer", "Teknisi Komputer"],
		gradient: "from-blue-600 to-cyan-500",
		colSpan: 2,
	},
];

export function ProgramsSection() {
	const sectionRef = useRef<HTMLElement>(null);
	const titleRef = useRef<HTMLDivElement>(null);

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
		}, sectionRef);

		return () => ctx.revert();
	}, []);

	return (
		<section
			ref={sectionRef}
			id="jurusan"
			className="relative bg-secondary/30 py-24 md:py-32 overflow-hidden"
		>
			<div className="top-20 right-0 absolute bg-primary/5 blur-3xl rounded-full w-96 h-96" />
			<div className="bottom-20 left-0 absolute bg-primary/5 blur-3xl rounded-full w-80 h-80" />

			<div className="relative mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
				<div ref={titleRef} className="mb-16 text-center">
					<span className="inline-block bg-primary/10 mb-4 px-4 py-2 rounded-full font-semibold text-primary text-sm">
						Pilih Minatmu
					</span>
					<h2 className="mb-6 font-bold text-foreground text-4xl md:text-5xl">
						Program Keahlian
					</h2>
					<p className="mx-auto max-w-2xl text-muted-foreground text-lg">
						Banyak pilihan program keahlian yang dapat dipilih sesuai dengan
						minat dan bakat siswa.
					</p>
				</div>

				<MagicBento items={programs} />
			</div>
		</section>
	);
}

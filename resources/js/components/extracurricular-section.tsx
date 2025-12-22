"use client";

import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import {
	BookOpen,
	Flag,
	Heart,
	Music,
	Palette,
	Tent,
	Trophy,
	Users,
} from "lucide-react";
import { useEffect, useRef } from "react";

gsap.registerPlugin(ScrollTrigger);

const extracurriculars = [
	{
		icon: Trophy,
		name: "Olahraga",
		description:
			"Futsal, Voli, Basket - raih prestasi dan beasiswa non-akademik",
		color: "bg-orange-500",
	},
	{
		icon: Palette,
		name: "Seni Rupa",
		description: "Melukis, desain grafis - kembangkan kreativitas visual",
		color: "bg-pink-500",
	},
	{
		icon: Music,
		name: "Seni Musik",
		description: "Band, hadrah - ekspresikan bakat musikmu",
		color: "bg-purple-500",
	},
	{
		icon: Tent,
		name: "Pramuka",
		description: "Kegiatan kepanduan untuk membentuk karakter dan kemandirian",
		color: "bg-amber-500",
	},
	{
		icon: Heart,
		name: "PMR",
		description: "Palang Merah Remaja untuk melatih jiwa kemanusiaan",
		color: "bg-red-500",
	},
	{
		icon: BookOpen,
		name: "Rohis",
		description: "Kegiatan kerohanian Islam untuk memperdalam ilmu agama",
		color: "bg-emerald-500",
	},
	{
		icon: Flag,
		name: "Paskibra",
		description: "Pasukan Pengibar Bendera untuk melatih kedisiplinan",
		color: "bg-blue-500",
	},
	{
		icon: Users,
		name: "IPNU/IPPNU",
		description: "Organisasi pelajar Nahdlatul Ulama",
		color: "bg-teal-500",
	},
];

export function ExtracurricularSection() {
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
					scrollTrigger: { trigger: titleRef.current, start: "top 80%" },
				},
			);

			cardsRef.current.forEach((card, index) => {
				if (card) {
					gsap.fromTo(
						card,
						{ opacity: 0, y: 40, scale: 0.9 },
						{
							opacity: 1,
							y: 0,
							scale: 1,
							duration: 0.5,
							delay: index * 0.08,
							ease: "back.out(1.5)",
							scrollTrigger: { trigger: card, start: "top 90%" },
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
			id="ekskul"
			className="py-24 md:py-32 bg-secondary/20 relative overflow-hidden"
		>
			<div className="absolute inset-0 opacity-30">
				<div className="absolute top-10 left-10 w-20 h-20 border-2 border-primary/20 rounded-full" />
				<div className="absolute bottom-20 right-20 w-32 h-32 border-2 border-primary/10 rounded-full" />
				<div className="absolute top-1/2 left-1/4 w-16 h-16 border border-primary/10 rounded-full" />
			</div>

			<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
				<div ref={titleRef} className="text-center mb-16">
					<span className="inline-block px-4 py-2 bg-primary/10 text-primary text-sm font-semibold rounded-full mb-4">
						Kembangkan Bakatmu
					</span>
					<h2 className="text-4xl md:text-5xl font-bold text-foreground mb-6">
						Ekstrakurikuler
					</h2>
					<p className="text-muted-foreground text-lg max-w-2xl mx-auto">
						Kembangkan minat dan bakatmu. Prestasi di bidang olahraga & seni
						bisa mendapat beasiswa!
					</p>
				</div>

				<div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
					{extracurriculars.map((ekskul, index) => (
						<div
							key={index}
							ref={(el) => {
								cardsRef.current[index] = el;
							}}
							className="bg-card p-6 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 group cursor-default border border-border hover:border-primary/50"
						>
							<div
								className={`w-14 h-14 ${ekskul.color} rounded-2xl flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300`}
							>
								<ekskul.icon className="w-7 h-7 text-white" />
							</div>
							<h3 className="font-bold text-foreground text-lg mb-2 group-hover:text-primary transition-colors">
								{ekskul.name}
							</h3>
							<p className="text-sm text-muted-foreground leading-relaxed">
								{ekskul.description}
							</p>
						</div>
					))}
				</div>
			</div>
		</section>
	);
}

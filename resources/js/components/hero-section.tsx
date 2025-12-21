import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ArrowRight, Award, Calendar, Users } from "lucide-react";
import { useEffect, useRef } from "react";

gsap.registerPlugin(ScrollTrigger);

export function HeroSection() {
	const sectionRef = useRef<HTMLElement>(null);
	const headingRef = useRef<HTMLHeadingElement>(null);
	const descRef = useRef<HTMLParagraphElement>(null);
	const buttonsRef = useRef<HTMLDivElement>(null);
	const statsRef = useRef<HTMLDivElement>(null);
	const overlayRef = useRef<HTMLDivElement>(null);

	useEffect(() => {
		const ctx = gsap.context(() => {
			const tl = gsap.timeline({ defaults: { ease: "power4.out" } });

			tl.fromTo(
				overlayRef.current,
				{ opacity: 0 },
				{ opacity: 1, duration: 1.2 },
			)
				.fromTo(
					headingRef.current,
					{ opacity: 0, y: 80, scale: 0.95 },
					{ opacity: 1, y: 0, scale: 1, duration: 1.2 },
					"-=0.8",
				)
				.fromTo(
					descRef.current,
					{ opacity: 0, y: 40 },
					{ opacity: 1, y: 0, duration: 0.9 },
					"-=0.6",
				)
				.fromTo(
					buttonsRef.current?.children || [],
					{ opacity: 0, y: 30 },
					{ opacity: 1, y: 0, duration: 0.7, stagger: 0.15 },
					"-=0.4",
				)
				.fromTo(
					statsRef.current?.children || [],
					{ opacity: 0, y: 20 },
					{ opacity: 1, y: 0, duration: 0.5, stagger: 0.1 },
					"-=0.3",
				);

			// Parallax effect on scroll
			gsap.to(".hero-bg", {
				yPercent: 30,
				scrollTrigger: {
					trigger: sectionRef.current,
					start: "top top",
					end: "bottom top",
					scrub: 1.5,
				},
			});
		}, sectionRef);

		return () => ctx.revert();
	}, []);

	return (
		<section
			ref={sectionRef}
			id="beranda"
			className="relative min-h-screen flex items-center justify-center overflow-hidden"
		>
			<div className="hero-bg absolute inset-0 -z-10">
				<img
					src="/indonesian-vocational-high-school-modern-building-.jpg"
					alt="SMK Diponegoro Karanganyar"
					className="w-full h-full object-cover scale-110"
				/>
			</div>

			{/* Gradient overlay */}
			<div
				ref={overlayRef}
				className="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/70 -z-10"
			/>

			{/* Decorative elements */}
			<div className="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-primary/20 to-transparent -z-10" />
			<div className="absolute bottom-0 left-0 w-full h-48 bg-gradient-to-t from-background to-transparent z-10" />

			<div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-20 pb-32 relative z-20">
				<h1
					ref={headingRef}
					className="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-[1.1] tracking-tight mb-6"
				>
					<span className="block drop-shadow-lg">
						Penerimaan Peserta Didik Baru
					</span>
					<span className="block mt-3 text-primary drop-shadow-lg">
						SMK Diponegoro Karanganyar
					</span>
					<span className="block mt-3 text-2xl sm:text-3xl md:text-4xl font-semibold text-white/90">
						Tahun Ajaran 2025/2026
					</span>
				</h1>

				<p
					ref={descRef}
					className="text-lg md:text-xl text-white/85 leading-relaxed max-w-2xl mx-auto mb-10 drop-shadow-md"
				>
					Wujudkan impianmu menjadi tenaga profesional yang kompeten dan
					berakhlak mulia. Bergabunglah dengan keluarga besar SMK Diponegoro
					Karanganyar.
				</p>

				<div
					ref={buttonsRef}
					className="flex flex-col sm:flex-row gap-4 justify-center mb-12"
				>
					<Button
						size="lg"
						className="rounded-full px-10 h-14 text-lg shadow-2xl shadow-primary/30 hover:shadow-primary/50 hover:scale-105 transition-all duration-300 bg-primary hover:bg-primary/90"
						asChild
					>
						<Link href="/pendaftaran" className="gap-2">
							Daftar Sekarang
							<ArrowRight className="w-5 h-5" />
						</Link>
					</Button>
					<Button
						size="lg"
						variant="outline"
						className="rounded-full px-10 h-14 text-lg border-2 border-white/50 text-white hover:bg-white/20 hover:border-white hover:scale-105 transition-all duration-300 bg-white/10 backdrop-blur-sm"
						asChild
					>
						<Link href="#jurusan">Lihat Jurusan</Link>
					</Button>
				</div>

				<div
					ref={statsRef}
					className="flex flex-wrap gap-6 md:gap-12 justify-center"
				>
					{[
						{ icon: Users, value: "500+", label: "Siswa Aktif" },
						{ icon: Award, value: "5", label: "Program Keahlian" },
						{ icon: Calendar, value: "2005", label: "Tahun Berdiri" },
					].map((stat, i) => (
						<div
							key={i}
							className="flex items-center gap-3 bg-white/10 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/20 hover:bg-white/20 hover:scale-105 transition-all duration-300"
						>
							<div className="w-12 h-12 bg-primary/20 rounded-xl flex items-center justify-center">
								<stat.icon className="w-6 h-6 text-primary" />
							</div>
							<div className="text-left">
								<p className="font-bold text-2xl text-white">{stat.value}</p>
								<p className="text-sm text-white/70">{stat.label}</p>
							</div>
						</div>
					))}
				</div>
			</div>
		</section>
	);
}

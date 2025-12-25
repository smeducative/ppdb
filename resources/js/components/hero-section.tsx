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
			className="relative flex justify-center items-center min-h-screen overflow-hidden"
		>
			<div className="-z-10 absolute inset-0 hero-bg">
				<img
					src="/img/gedung-smk-bg.png"
					alt="SMK Diponegoro Karanganyar"
					className="w-full h-full object-cover scale-110"
				/>
			</div>

			{/* Gradient overlay */}
			<div
				ref={overlayRef}
				className="-z-10 absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/70"
			/>

			{/* Decorative elements */}
			<div className="top-0 left-0 -z-10 absolute bg-gradient-to-b from-primary/20 to-transparent w-full h-32" />
			<div className="bottom-0 left-0 z-10 absolute bg-gradient-to-t from-background to-transparent w-full h-48" />

			<div className="z-20 relative mx-auto px-4 sm:px-6 lg:px-8 pt-36 pb-32 max-w-5xl text-center">
				<h1
					ref={headingRef}
					className="mb-6 font-bold text-white text-4xl sm:text-5xl md:text-6xl lg:text-7xl leading-[1.1] tracking-tight"
				>
					<span className="block drop-shadow-lg">
						Sistem Penerimaan Murid Baru
					</span>
					<span className="block drop-shadow-lg mt-3 text-primary">
						SMK Diponegoro Karanganyar
					</span>
					<span className="block mt-3 font-semibold text-white/90 text-2xl sm:text-3xl md:text-4xl">
						Tahun Ajaran 2026/2027
					</span>
				</h1>

				<p
					ref={descRef}
					className="drop-shadow-md mx-auto mb-10 max-w-2xl text-white/85 text-lg md:text-xl leading-relaxed"
				>
					Wujudkan impianmu menjadi tenaga profesional yang kompeten dan
					berakhlak mulia. Bergabunglah dengan keluarga besar SMK Diponegoro
					Karanganyar.
				</p>

				<div
					ref={buttonsRef}
					className="flex sm:flex-row flex-col justify-center gap-4 mb-12"
				>
					<Button
						size="lg"
						className="bg-primary hover:bg-primary/90 shadow-2xl shadow-primary/30 hover:shadow-primary/50 px-10 rounded-full h-14 text-lg hover:scale-105 transition-all duration-300"
						asChild
					>
						<Link href="/register" className="gap-2">
							Daftar Sekarang
							<ArrowRight className="w-5 h-5" />
						</Link>
					</Button>
					<Button
						size="lg"
						variant="outline"
						className="bg-white/10 hover:bg-white/20 backdrop-blur-sm px-10 border-2 border-white/50 hover:border-white rounded-full h-14 text-white text-lg hover:scale-105 transition-all duration-300"
						asChild
					>
						<Link href="#jurusan">Lihat Jurusan</Link>
					</Button>
				</div>

				<div
					ref={statsRef}
					className="flex flex-wrap justify-center gap-6 md:gap-12"
				>
					{[
						{ icon: Users, value: "500+", label: "Siswa Aktif" },
						{ icon: Award, value: "5", label: "Program Keahlian" },
						{ icon: Calendar, value: "2008", label: "Tahun Berdiri" },
					].map((stat) => (
						<div
							key={stat.label}
							className="flex items-center gap-3 bg-white/10 hover:bg-white/20 backdrop-blur-md px-5 py-3 border border-white/20 rounded-2xl hover:scale-105 transition-all duration-300"
						>
							<div className="flex justify-center items-center bg-primary/20 rounded-xl w-12 h-12">
								<stat.icon className="w-6 h-6 text-primary" />
							</div>
							<div className="text-left">
								<p className="font-bold text-white text-2xl">{stat.value}</p>
								<p className="text-white/70 text-sm">{stat.label}</p>
							</div>
						</div>
					))}
				</div>
			</div>
		</section>
	);
}

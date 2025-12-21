import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ArrowRight, Calendar, Phone, Sparkles } from "lucide-react";
import { useEffect, useRef } from "react";

gsap.registerPlugin(ScrollTrigger);

export function CTASection() {
	const sectionRef = useRef<HTMLElement>(null);
	const contentRef = useRef<HTMLDivElement>(null);
	const floatingRef = useRef<HTMLDivElement>(null);

	useEffect(() => {
		const ctx = gsap.context(() => {
			gsap.fromTo(
				contentRef.current,
				{ opacity: 0, y: 60, scale: 0.95 },
				{
					opacity: 1,
					y: 0,
					scale: 1,
					duration: 1,
					ease: "power3.out",
					scrollTrigger: { trigger: sectionRef.current, start: "top 70%" },
				},
			);

			gsap.to(".cta-float", {
				y: -15,
				duration: 2.5,
				repeat: -1,
				yoyo: true,
				ease: "power1.inOut",
				stagger: 0.3,
			});
		}, sectionRef);

		return () => ctx.revert();
	}, []);

	return (
		<section
			ref={sectionRef}
			id="daftar"
			className="py-24 md:py-32 bg-primary relative overflow-hidden"
		>
			<div className="absolute inset-0">
				<div className="cta-float absolute top-10 left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl" />
				<div className="cta-float absolute bottom-10 right-10 w-48 h-48 bg-white/10 rounded-full blur-3xl" />
				<div className="cta-float absolute top-1/2 right-1/4 w-24 h-24 bg-white/5 rounded-full blur-xl" />
			</div>

			<div className="absolute top-20 right-20 w-4 h-4 bg-white/30 rounded-full" />
			<div className="absolute bottom-32 left-20 w-3 h-3 bg-white/20 rounded-full" />
			<div className="absolute top-40 left-1/3 w-2 h-2 bg-white/40 rounded-full" />

			<div
				ref={contentRef}
				className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10"
			>
				<div className="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-5 py-2.5 rounded-full text-sm font-semibold mb-8">
					<Sparkles className="w-4 h-4" />
					Kuota Terbatas!
				</div>

				<h2 className="text-4xl md:text-5xl lg:text-6xl font-bold text-primary-foreground mb-6 leading-tight">
					Siap Memulai Perjalanan Pendidikanmu?
				</h2>

				<p className="text-primary-foreground/90 text-lg md:text-xl mb-10 max-w-2xl mx-auto leading-relaxed">
					Jangan lewatkan kesempatan untuk menjadi bagian dari keluarga besar
					SMK Diponegoro Karanganyar. Pendaftaran tahun ajaran 2026/2027 telah
					dibuka!
				</p>

				<div className="flex flex-col sm:flex-row gap-4 justify-center mb-12">
					<Button
						size="lg"
						variant="secondary"
						className="rounded-full px-8 h-14 text-base shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300"
						asChild
					>
						<Link href="/register" className="gap-2">
							Daftar Online Sekarang
							<ArrowRight className="w-5 h-5" />
						</Link>
					</Button>
					<Button
						size="lg"
						variant="outline"
						className="rounded-full px-8 h-14 text-base bg-transparent border-2 border-primary-foreground text-primary-foreground hover:bg-primary-foreground hover:text-primary transition-all duration-300"
						asChild
					>
						<Link href="tel:+62285123456" className="gap-2">
							<Phone className="w-5 h-5" />
							Hubungi Kami
						</Link>
					</Button>
				</div>

				<div className="inline-flex items-center gap-4 bg-white/15 backdrop-blur-md rounded-2xl p-6 border border-white/20">
					<div className="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
						<Calendar className="w-7 h-7 text-white" />
					</div>
					<div className="text-left">
						<p className="font-bold text-white text-lg">Periode Pendaftaran</p>
						<p className="text-white/80">1 Januari - 30 Juni 2026</p>
					</div>
				</div>
			</div>
		</section>
	);
}

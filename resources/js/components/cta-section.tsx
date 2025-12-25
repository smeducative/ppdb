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
			className="relative bg-primary dark:bg-primary/90 py-24 md:py-32 overflow-hidden"
		>
			<div className="absolute inset-0">
				<div className="top-10 left-10 cta-float absolute bg-primary-foreground/10 dark:bg-primary-foreground/5 blur-2xl rounded-full w-32 h-32" />
				<div className="right-10 bottom-10 cta-float absolute bg-primary-foreground/10 dark:bg-primary-foreground/5 blur-3xl rounded-full w-48 h-48" />
				<div className="top-1/2 right-1/4 cta-float absolute bg-primary-foreground/5 dark:bg-primary-foreground/3 blur-xl rounded-full w-24 h-24" />
			</div>

			<div className="top-20 right-20 absolute bg-primary-foreground/30 dark:bg-primary-foreground/20 rounded-full w-4 h-4" />
			<div className="bottom-32 left-20 absolute bg-primary-foreground/20 dark:bg-primary-foreground/15 rounded-full w-3 h-3" />
			<div className="top-40 left-1/3 absolute bg-primary-foreground/40 dark:bg-primary-foreground/25 rounded-full w-2 h-2" />

			<div
				ref={contentRef}
				className="z-10 relative mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl text-center"
			>
				<div className="inline-flex items-center gap-2 bg-primary-foreground/20 dark:bg-primary-foreground/15 backdrop-blur-sm mb-8 px-5 py-2.5 rounded-full font-semibold text-primary-foreground text-sm">
					<Sparkles className="w-4 h-4" />
					Kuota Terbatas!
				</div>

				<h2 className="mb-6 font-bold text-primary-foreground text-4xl md:text-5xl lg:text-6xl leading-tight">
					Siap Memulai Perjalanan Pendidikanmu?
				</h2>

				<p className="mx-auto mb-10 max-w-2xl text-primary-foreground/90 dark:text-primary-foreground/85 text-lg md:text-xl leading-relaxed">
					Jangan lewatkan kesempatan untuk menjadi bagian dari keluarga besar
					SMK Diponegoro Karanganyar. Pendaftaran tahun ajaran 2026/2027 telah
					dibuka!
				</p>

				<div className="flex sm:flex-row flex-col justify-center gap-4 mb-12">
					<Button
						size="lg"
						variant="secondary"
						className="shadow-xl hover:shadow-2xl px-8 rounded-full h-14 text-base hover:scale-105 transition-all duration-300"
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
						className="bg-transparent hover:bg-primary-foreground dark:hover:bg-primary-foreground/90 px-8 border-2 border-primary-foreground rounded-full h-14 text-primary-foreground hover:text-primary dark:hover:text-primary text-base transition-all duration-300"
						asChild
					>
						<Link href="tel:+62285123456" className="gap-2">
							<Phone className="w-5 h-5" />
							Hubungi Kami
						</Link>
					</Button>
				</div>

				<div className="inline-flex items-center gap-4 bg-primary-foreground/15 dark:bg-primary-foreground/10 backdrop-blur-md p-6 border border-primary-foreground/20 dark:border-primary-foreground/15 rounded-2xl">
					<div className="flex justify-center items-center bg-primary-foreground/20 dark:bg-primary-foreground/15 rounded-xl w-14 h-14">
						<Calendar className="w-7 h-7 text-primary-foreground" />
					</div>
					<div className="text-left">
						<p className="font-bold text-primary-foreground text-lg">
							Periode Pendaftaran
						</p>
						<p className="text-primary-foreground/80 dark:text-primary-foreground/75">
							1 Januari - 30 Juni 2026
						</p>
					</div>
				</div>
			</div>
		</section>
	);
}

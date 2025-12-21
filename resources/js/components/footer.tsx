"use client";

import { Link } from "@inertiajs/react";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import {
	ArrowUp,
	Clock,
	Facebook,
	GraduationCap,
	Instagram,
	Mail,
	MapPin,
	Phone,
	Youtube,
} from "lucide-react";
import { useEffect, useRef } from "react";

gsap.registerPlugin(ScrollTrigger);

const quickLinks = [
	{ label: "Beranda", href: "#beranda" },
	{ label: "Alur Pendaftaran", href: "#alur" },
	{ label: "Program Keahlian", href: "#jurusan" },
	{ label: "Fasilitas", href: "#fasilitas" },
	{ label: "Ekstrakurikuler", href: "#ekskul" },
];

const programs = [
	{ label: "Teknik Komputer & Jaringan", href: "#jurusan" },
	{ label: "Agribisnis Tanaman Pangan", href: "#jurusan" },
	{ label: "Teknik Sepeda Motor", href: "#jurusan" },
];

export function Footer() {
	const footerRef = useRef<HTMLElement>(null);
	const contentRef = useRef<HTMLDivElement>(null);

	useEffect(() => {
		const ctx = gsap.context(() => {
			gsap.fromTo(
				contentRef.current,
				{ opacity: 0, y: 40 },
				{
					opacity: 1,
					y: 0,
					duration: 0.8,
					scrollTrigger: { trigger: footerRef.current, start: "top 90%" },
				},
			);
		}, footerRef);

		return () => ctx.revert();
	}, []);

	const scrollToTop = () => {
		window.scrollTo({ top: 0, behavior: "smooth" });
	};

	return (
		<footer ref={footerRef} className="bg-foreground text-background relative">
			<button
				onClick={scrollToTop}
				className="absolute -top-6 left-1/2 -translate-x-1/2 w-12 h-12 bg-primary rounded-full flex items-center justify-center shadow-lg hover:scale-110 hover:shadow-xl transition-all duration-300"
				aria-label="Scroll to top"
			>
				<ArrowUp className="w-5 h-5 text-primary-foreground" />
			</button>

			<div
				ref={contentRef}
				className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16"
			>
				<div className="grid md:grid-cols-2 lg:grid-cols-4 gap-10">
					<div className="space-y-6">
						<Link href="/" className="flex items-center gap-3 group">
							<div className="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
								<GraduationCap className="w-7 h-7 text-primary-foreground" />
							</div>
							<div>
								<p className="font-bold text-background text-lg leading-tight">
									SMK Diponegoro
								</p>
								<p className="text-xs text-background/70 font-medium">
									Karanganyar
								</p>
							</div>
						</Link>
						<p className="text-sm text-background/70 leading-relaxed">
							Mewujudkan generasi yang beriman, berilmu, dan terampil untuk
							menghadapi tantangan dunia kerja global.
						</p>
						<div className="flex gap-3">
							{[
								{ icon: Facebook, href: "#" },
								{ icon: Instagram, href: "#" },
								{ icon: Youtube, href: "#" },
							].map((social, i) => (
								<Link
									key={i}
									href={social.href}
									className="w-10 h-10 bg-background/10 rounded-xl flex items-center justify-center hover:bg-primary hover:scale-110 transition-all duration-300"
								>
									<social.icon className="w-5 h-5" />
								</Link>
							))}
						</div>
					</div>

					<div>
						<h4 className="font-bold text-background text-lg mb-6">
							Link Cepat
						</h4>
						<ul className="space-y-3">
							{quickLinks.map((link, index) => (
								<li key={index}>
									<Link
										href={link.href}
										className="text-sm text-background/70 hover:text-primary hover:translate-x-1 transition-all duration-300 inline-block"
									>
										{link.label}
									</Link>
								</li>
							))}
						</ul>
					</div>

					<div>
						<h4 className="font-bold text-background text-lg mb-6">
							Program Keahlian
						</h4>
						<ul className="space-y-3">
							{programs.map((program, index) => (
								<li key={index}>
									<Link
										href={program.href}
										className="text-sm text-background/70 hover:text-primary hover:translate-x-1 transition-all duration-300 inline-block"
									>
										{program.label}
									</Link>
								</li>
							))}
						</ul>
					</div>

					<div>
						<h4 className="font-bold text-background text-lg mb-6">Kontak</h4>
						<ul className="space-y-4">
							{[
								{
									icon: MapPin,
									text: "Jl. Raya Karanganyar KM 1.5, Kayugeritan, Kec. Karanganyar, Kabupaten Pekalongan, Jawa Tengah 51182",
								},
								{ icon: Phone, text: "(0285) 123456" },
								{ icon: Mail, text: "info@smkdiponegoro-karanganyar.sch.id" },
								{ icon: Clock, text: "Senin - Sabtu: 07:00 - 15:00" },
							].map((item, index) => (
								<li key={index} className="flex items-start gap-3 group">
									<div className="w-8 h-8 bg-primary/20 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-primary group-hover:scale-110 transition-all duration-300">
										<item.icon className="w-4 h-4 text-primary group-hover:text-primary-foreground transition-colors" />
									</div>
									<span className="text-sm text-background/70">
										{item.text}
									</span>
								</li>
							))}
						</ul>
					</div>
				</div>

				<div className="border-t border-background/10 mt-12 pt-8">
					<div className="flex flex-col md:flex-row justify-between items-center gap-4">
						<p className="text-sm text-background/60">
							&copy; {new Date().getFullYear()} SMK Diponegoro Karanganyar. Hak
							Cipta Dilindungi.
						</p>
						<p className="text-sm text-background/60">
							SPMB Tahun Ajaran 2025/2026
						</p>
					</div>
				</div>
			</div>
		</footer>
	);
}

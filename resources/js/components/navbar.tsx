import { Link, usePage } from "@inertiajs/react";
import gsap from "gsap";
import { Menu, X } from "lucide-react";
import { useEffect, useRef, useState } from "react";
import { ModeToggle } from "@/components/mode-toggle";
import { Button } from "@/components/ui/button";

const navLinks = [
	{ href: "/#beranda", label: "Beranda" },
	{ href: "/#alur", label: "Alur Pendaftaran" },
	{ href: "/#jurusan", label: "Jurusan" },
	{ href: "/#fasilitas", label: "Fasilitas" },
	{ href: "/#ekskul", label: "Ekstrakurikuler" },
];

export function Navbar() {
	const [isOpen, setIsOpen] = useState(false);
	const [scrolled, setScrolled] = useState(false);
	const { url } = usePage();
	const pathname = url;
	const navRef = useRef<HTMLElement>(null);
	const logoRef = useRef<HTMLAnchorElement>(null);
	const linksRef = useRef<HTMLDivElement>(null);
	const buttonRef = useRef<HTMLDivElement>(null);

	const isRegistrationPage = pathname === "/register";

	useEffect(() => {
		const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

		tl.fromTo(
			logoRef.current,
			{ opacity: 0, x: -30 },
			{ opacity: 1, x: 0, duration: 0.8 },
		)
			.fromTo(
				linksRef.current?.children || [],
				{ opacity: 0, y: -20 },
				{ opacity: 1, y: 0, duration: 0.5, stagger: 0.1 },
				"-=0.4",
			)
			.fromTo(
				buttonRef.current,
				{ opacity: 0, scale: 0.8 },
				{ opacity: 1, scale: 1, duration: 0.5 },
				"-=0.3",
			);

		const handleScroll = () => {
			setScrolled(window.scrollY > 50);
		};
		window.addEventListener("scroll", handleScroll);
		return () => window.removeEventListener("scroll", handleScroll);
	}, []);

	const navBackground =
		scrolled || isRegistrationPage
			? "bg-background/90 backdrop-blur-xl shadow-lg py-2 border-b border-border"
			: "bg-transparent py-4";

	const textColor =
		scrolled || isRegistrationPage
			? "text-muted-foreground hover:text-primary"
			: "text-white/80 hover:text-white";

	const logoTextColor =
		scrolled || isRegistrationPage
			? "text-foreground"
			: "text-white drop-shadow-lg";

	return (
		<nav
			ref={navRef}
			className={`fixed top-0 left-0 right-0 z-50 transition-all duration-500 ${navBackground}`}
		>
			<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div className="flex items-center justify-between">
					<Link
						ref={logoRef}
						href="/"
						className="flex items-center gap-3 group"
					>
						<div className="w-12 h-12 rounded-2xl overflow-hidden shadow-lg group-hover:shadow-primary/30 group-hover:scale-105 transition-all duration-300">
							<img
								src="/img/logo.png"
								alt="SMK Diponegoro Karanganyar Logo"
								className="w-full h-full object-contain"
							/>
						</div>
						<div className="hidden sm:block">
							<p
								className={`font-bold text-lg leading-tight transition-colors ${logoTextColor}`}
							>
								SMK Diponegoro Karanganyar
							</p>
							<p
								className={`text-xs font-medium transition-colors ${scrolled || isRegistrationPage ? "text-muted-foreground" : "text-white/70 drop-shadow-md"}`}
							>
								Kab. Pekalongan
							</p>
						</div>
					</Link>

					<div ref={linksRef} className="hidden md:flex items-center gap-1">
						{navLinks.map((link) => (
							<Link
								key={link.href}
								href={link.href}
								className={`relative px-4 py-2 text-sm font-medium transition-colors group ${textColor}`}
							>
								{link.label}
								<span className="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-primary rounded-full group-hover:w-3/4 transition-all duration-300" />
							</Link>
						))}
					</div>

					<div ref={buttonRef} className="hidden md:flex items-center gap-3">
						<ModeToggle />
						<Button
							size="lg"
							className="rounded-full px-6 shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 hover:scale-105 transition-all duration-300"
							asChild
						>
							<Link href="/register">Daftar Sekarang</Link>
						</Button>
					</div>

					<button
						type="button"
						className={`md:hidden p-2 rounded-xl transition-colors ${scrolled || isRegistrationPage ? "hover:bg-primary/10" : "hover:bg-white/10"}`}
						onClick={() => setIsOpen(!isOpen)}
						aria-label="Toggle menu"
					>
						{isOpen ? (
							<X
								className={`w-6 h-6 ${scrolled || isRegistrationPage ? "text-foreground" : "text-white"}`}
							/>
						) : (
							<Menu
								className={`w-6 h-6 ${scrolled || isRegistrationPage ? "text-foreground" : "text-white"}`}
							/>
						)}
					</button>
				</div>
			</div>

			<div
				className={`md:hidden overflow-hidden transition-all duration-500 ${isOpen ? "max-h-96" : "max-h-0"}`}
			>
				<div className="px-4 py-6 space-y-2 bg-background/95 backdrop-blur-xl border-t border-border">
					{navLinks.map((link, index) => (
						<Link
							key={link.href}
							href={link.href}
							className="block px-4 py-3 text-sm font-medium text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-xl transition-all"
							onClick={() => setIsOpen(false)}
							style={{ animationDelay: `${index * 50}ms` }}
						>
							{link.label}
						</Link>
					))}
					<Button asChild className="w-full mt-4 rounded-full">
						<Link href="/pendaftaran">Daftar Sekarang</Link>
					</Button>
				</div>
			</div>
		</nav>
	);
}

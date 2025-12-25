"use client";

import { cn } from "@/lib/utils";
import gsap from "gsap";
import type React from "react";
import { useEffect, useRef, useState } from "react";

interface BentoCardProps extends React.HTMLAttributes<HTMLDivElement> {
	title: string;
	description: string;
	icon?: React.ElementType;
	gradient?: string;
	colSpan?: number;
	rowSpan?: number;
	enableTilt?: boolean;
	enableMagnetism?: boolean;
	clickEffect?: boolean;
	glowColor?: string;
	disableAnimations?: boolean;
	skills?: string[];
	prospects?: string[];
	badge?: string;
	shortName?: string;
}

interface MagicBentoProps {
	items: {
		title: string;
		description: string;
		icon: React.ElementType;
		gradient: string;
		colSpan?: number;
		rowSpan?: number;
		skills?: string[];
		prospects?: string[];
		badge?: string;
		shortName?: string;
		[key: string]: any;
	}[];
	enableStars?: boolean;
	enableSpotlight?: boolean;
	enableBorderGlow?: boolean;
	disableAnimations?: boolean;
	spotlightRadius?: number;
	particleCount?: number;
	enableTilt?: boolean;
	glowColor?: string;
	clickEffect?: boolean;
	enableMagnetism?: boolean;
}

const DEFAULT_PARTICLE_COUNT = 12;
const DEFAULT_SPOTLIGHT_RADIUS = 300;
const DEFAULT_GLOW_COLOR = "132, 0, 255";
const MOBILE_BREAKPOINT = 768;

const useMobileDetection = () => {
	const [isMobile, setIsMobile] = useState(false);

	useEffect(() => {
		const checkMobile = () =>
			setIsMobile(window.innerWidth <= MOBILE_BREAKPOINT);
		checkMobile();
		window.addEventListener("resize", checkMobile);
		return () => window.removeEventListener("resize", checkMobile);
	}, []);

	return isMobile;
};

const GlobalSpotlight = ({
	gridRef,
	disableAnimations,
	enabled,
	spotlightRadius,
	glowColor,
}: any) => {
	const spotlightRef = useRef<HTMLDivElement>(null);

	useEffect(() => {
		if (disableAnimations || !gridRef?.current || !enabled) return;

		const spotlight = document.createElement("div");
		spotlight.className =
			"global-spotlight fixed pointer-events-none z-[200] mix-blend-screen opacity-0 transition-opacity duration-300";
		spotlight.style.width = `${spotlightRadius * 2}px`;
		spotlight.style.height = `${spotlightRadius * 2}px`;
		spotlight.style.borderRadius = "50%";
		spotlight.style.background = `radial-gradient(circle,
      rgba(${glowColor}, 0.15) 0%,
      rgba(${glowColor}, 0.08) 15%,
      rgba(${glowColor}, 0.04) 25%,
      rgba(${glowColor}, 0.02) 40%,
      rgba(${glowColor}, 0.01) 65%,
      transparent 70%
    )`;
		spotlight.style.transform = "translate(-50%, -50%)";

		document.body.appendChild(spotlight);
		spotlightRef.current = spotlight;

		const handleMouseMove = (e: MouseEvent) => {
			if (!spotlightRef.current) return;
			gsap.to(spotlightRef.current, {
				x: e.clientX,
				y: e.clientY,
				duration: 0.6,
				ease: "power2.out",
				opacity: 1,
			});
		};

		const handleMouseLeave = () => {
			if (!spotlightRef.current) return;
			gsap.to(spotlightRef.current, { opacity: 0, duration: 0.3 });
		};

		window.addEventListener("mousemove", handleMouseMove);
		document.addEventListener("mouseleave", handleMouseLeave);

		return () => {
			window.removeEventListener("mousemove", handleMouseMove);
			document.removeEventListener("mouseleave", handleMouseLeave);
			spotlightRef.current?.remove();
		};
	}, [gridRef, disableAnimations, enabled, spotlightRadius, glowColor]);

	return null;
};

const BentoCard = ({
	title,
	description,
	icon: Icon,
	gradient,
	className,
	enableTilt,
	enableMagnetism,
	clickEffect,
	glowColor,
	disableAnimations,
	skills,
	prospects,
	badge,
	shortName,
	...props
}: BentoCardProps) => {
	const cardRef = useRef<HTMLDivElement>(null);

	useEffect(() => {
		const el = cardRef.current;
		if (!el || disableAnimations) return;

		const handleMouseMove = (e: MouseEvent) => {
			const rect = el.getBoundingClientRect();
			const x = e.clientX - rect.left;
			const y = e.clientY - rect.top;
			const centerX = rect.width / 2;
			const centerY = rect.height / 2;

			if (enableTilt) {
				const rotateX = ((y - centerY) / centerY) * -10;
				const rotateY = ((x - centerX) / centerX) * 10;

				gsap.to(el, {
					rotateX,
					rotateY,
					duration: 0.1,
					ease: "power2.out",
					transformPerspective: 1000,
				});
			}

			if (enableMagnetism) {
				const magnetX = (x - centerX) * 0.05;
				const magnetY = (y - centerY) * 0.05;

				gsap.to(el, {
					x: magnetX,
					y: magnetY,
					duration: 0.3,
					ease: "power2.out",
				});
			}
		};

		const handleMouseLeave = () => {
			if (enableTilt) {
				gsap.to(el, {
					rotateX: 0,
					rotateY: 0,
					duration: 0.3,
					ease: "power2.out",
				});
			}
			if (enableMagnetism) {
				gsap.to(el, { x: 0, y: 0, duration: 0.3, ease: "power2.out" });
			}
		};

		const handleClick = (e: MouseEvent) => {
			if (!clickEffect) return;

			const rect = el.getBoundingClientRect();
			const x = e.clientX - rect.left;
			const y = e.clientY - rect.top;

			const maxDistance = Math.max(
				Math.hypot(x, y),
				Math.hypot(x - rect.width, y),
				Math.hypot(x, y - rect.height),
				Math.hypot(x - rect.width, y - rect.height),
			);

			const ripple = document.createElement("div");
			ripple.style.cssText = `
        position: absolute;
        width: ${maxDistance * 2}px;
        height: ${maxDistance * 2}px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(${glowColor}, 0.4) 0%, rgba(${glowColor}, 0.2) 30%, transparent 70%);
        left: ${x - maxDistance}px;
        top: ${y - maxDistance}px;
        pointer-events: none;
        z-index: 10;
      `;

			el.appendChild(ripple);

			gsap.fromTo(
				ripple,
				{ scale: 0, opacity: 1 },
				{
					scale: 1,
					opacity: 0,
					duration: 0.8,
					ease: "power2.out",
					onComplete: () => ripple.remove(),
				},
			);
		};

		el.addEventListener("mousemove", handleMouseMove);
		el.addEventListener("mouseleave", handleMouseLeave);
		el.addEventListener("click", handleClick);

		return () => {
			el.removeEventListener("mousemove", handleMouseMove);
			el.removeEventListener("mouseleave", handleMouseLeave);
			el.removeEventListener("click", handleClick);
		};
	}, [enableTilt, enableMagnetism, clickEffect, glowColor, disableAnimations]);

	return (
		<div
			ref={cardRef}
			className={cn(
				"relative bg-card dark:bg-white/5 dark:hover:bg-white/10 shadow-sm hover:shadow-md dark:backdrop-blur-sm p-6 border border-border dark:border-white/10 rounded-2xl overflow-hidden transition-all",
				className,
			)}
			{...props}
		>
			<div
				className={`absolute inset-0 bg-gradient-to-br ${gradient} opacity-5 dark:opacity-10`}
			/>

			<div className="z-10 relative flex flex-col justify-between h-full">
				<div className="mb-4">
					<div className="flex justify-between items-start mb-4">
						{Icon && (
							<div
								className={`inline-flex rounded-lg bg-gradient-to-br ${gradient} p-3 text-white shadow-lg`}
							>
								<Icon size={24} />
							</div>
						)}
						{badge && (
							<span className="bg-green-100 dark:bg-green-900/20 px-3 py-1 rounded-full font-bold text-green-700 dark:text-green-400 text-xs">
								{badge}
							</span>
						)}
					</div>

					{shortName && (
						<span className="inline-block bg-primary/10 dark:bg-white/10 mb-3 px-3 py-1 rounded-full font-bold text-primary dark:text-white text-xs">
							{shortName}
						</span>
					)}

					<h3 className="mb-2 font-bold text-foreground dark:text-white text-xl">
						{title}
					</h3>
					<p className="mb-4 text-muted-foreground dark:text-gray-300 text-sm line-clamp-3">
						{description}
					</p>

					{skills && (
						<div className="mb-3">
							<p className="mb-2 font-semibold text-foreground dark:text-white text-xs">
								Kompetensi:
							</p>
							<ul className="space-y-1">
								{skills.slice(0, 3).map((skill, i) => (
									<li
										key={i}
										className="flex items-center gap-2 text-muted-foreground dark:text-gray-400 text-xs"
									>
										<span
											className={`w-1.5 h-1.5 rounded-full shrink-0 bg-gradient-to-br ${gradient}`}
										/>
										{skill}
									</li>
								))}
							</ul>
						</div>
					)}
				</div>

				{prospects && (
					<div>
						<p className="mb-2 font-semibold text-foreground dark:text-white text-xs">
							Prospek Karir:
						</p>
						<div className="flex flex-wrap gap-1.5">
							{prospects.slice(0, 3).map((prospect, i) => (
								<span
									key={i}
									className="bg-secondary dark:bg-white/10 px-2 py-1 rounded-full font-medium text-secondary-foreground dark:text-gray-200 text-xs"
								>
									{prospect}
								</span>
							))}
						</div>
					</div>
				)}
			</div>
		</div>
	);
};

export function MagicBento({
	items,
	enableStars = true,
	enableSpotlight = true,
	enableBorderGlow = true,
	disableAnimations = false,
	spotlightRadius = DEFAULT_SPOTLIGHT_RADIUS,
	particleCount = DEFAULT_PARTICLE_COUNT,
	enableTilt = true,
	glowColor = DEFAULT_GLOW_COLOR,
	clickEffect = true,
	enableMagnetism = true,
}: MagicBentoProps) {
	const gridRef = useRef<HTMLDivElement>(null);
	const isMobile = useMobileDetection();
	const shouldDisableAnimations = disableAnimations || isMobile;

	return (
		<div className="relative w-full" ref={gridRef}>
			{enableSpotlight && (
				<GlobalSpotlight
					gridRef={gridRef}
					disableAnimations={shouldDisableAnimations}
					enabled={enableSpotlight}
					spotlightRadius={spotlightRadius}
					glowColor={glowColor}
				/>
			)}

			<div className="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 auto-rows-[minmax(250px,auto)]">
				{items.map((item, index) => (
					<BentoCard
						key={index}
						{...item}
						className={cn(
							item.colSpan ? `md:col-span-${item.colSpan}` : "",
							item.rowSpan ? `md:row-span-${item.rowSpan}` : "",
						)}
						enableTilt={enableTilt}
						enableMagnetism={enableMagnetism}
						clickEffect={clickEffect}
						glowColor={glowColor}
						disableAnimations={shouldDisableAnimations}
					/>
				))}
			</div>
		</div>
	);
}

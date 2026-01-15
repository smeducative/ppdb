import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import {
	BookOpen,
	Clock,
	GraduationCap,
	Leaf,
	Trophy,
	Users,
} from "lucide-react";
import { useEffect, useRef } from "react";

gsap.registerPlugin(ScrollTrigger);

const scholarships = [
	{
		icon: GraduationCap,
		title: "Beasiswa Akademik",
		description: "Untuk siswa dengan peringkat 1/2/3 di SMP/MTs",
		benefits: [
			{ rank: "Peringkat 1", reward: "Bebas SPP 1,5 Tahun" },
			{ rank: "Peringkat 2", reward: "Bebas SPP 1 Tahun" },
			{ rank: "Peringkat 3", reward: "Bebas SPP 1 Semester" },
		],
		color: "from-blue-500 to-indigo-600",
		requirement:
			"Dibuktikan dengan fotokopi raport yang dilegalisir & surat keterangan dari Kepala Sekolah SMP/MTs",
	},
	{
		icon: Trophy,
		title: "Beasiswa Non Akademik",
		description: "Untuk siswa berprestasi di bidang Olahraga/Seni",
		benefits: [
			{ rank: "Juara 1 Provinsi", reward: "Bebas SPP 3 Tahun" },
			{ rank: "Juara 1 Karesidenan", reward: "Bebas SPP 2 Tahun" },
			{ rank: "Juara 1 Kabupaten", reward: "Bebas SPP 1,5 Tahun" },
		],
		color: "from-amber-500 to-orange-600",
		requirement: "Dibuktikan dengan fotokopi Sertifikat/Piagam penghargaan",
	},
	{
		icon: BookOpen,
		title: "Beasiswa Hafidz/Hafidzah",
		description: "Untuk siswa yang hafal Al-Qur'an minimal 1 Juz",
		benefits: [
			{ rank: "Hafal 1 Juz+", reward: "Bebas Biaya Pendidikan Selama Sekolah" },
		],
		color: "from-emerald-500 to-green-600",
		requirement: "Dibuktikan dengan tes hafalan di depan petugas",
	},
	{
		icon: Users,
		title: "Beasiswa Rekomendasi MWC",
		description: "Usulan dari Pengurus Ranting NU Se-MWC Karanganyar",
		benefits: [{ rank: "Rekomendasi MWC", reward: "Bebas SPP 1,5 Tahun" }],
		color: "from-teal-500 to-cyan-600",
		requirement: "Berlaku untuk jurusan TKR, TJKT, dan BCF",
	},
	{
		icon: Leaf,
		title: "Beasiswa Smart Farming",
		description: "Untuk seluruh siswa jurusan Agribisnis Tanaman",
		benefits: [
			{ rank: "Jurusan AT", reward: "Subsidi SPP 50% selama 3 Tahun" },
		],
		color: "from-green-500 to-lime-600",
		requirement: "Otomatis untuk semua siswa yang memilih jurusan AT",
	},
	{
		icon: Clock,
		title: "Beasiswa Subsidi DPP 50%",
		description: "Untuk 50 pendaftar ulang pertama atau saudara alumni",
		benefits: [
			{ rank: "50 Pendaftar Pertama", reward: "Subsidi DPP 50%" },
			{ rank: "Saudara Kandung/Alumni", reward: "Subsidi DPP 50%" },
		],
		color: "from-purple-500 to-pink-600",
		requirement: "Dibuktikan dengan Kartu Keluarga",
	},
];

export function ScholarshipSection() {
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
						{ opacity: 0, y: 60, scale: 0.95 },
						{
							opacity: 1,
							y: 0,
							scale: 1,
							duration: 0.6,
							delay: index * 0.1,
							ease: "power3.out",
							scrollTrigger: { trigger: card, start: "top 85%" },
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
			id="beasiswa"
			className="py-24 md:py-32 bg-gradient-to-b from-background to-secondary/30 relative overflow-hidden"
		>
			<div className="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl" />
			<div className="absolute bottom-0 left-0 w-80 h-80 bg-amber-500/5 rounded-full blur-3xl" />

			<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
				<div ref={titleRef} className="text-center mb-16">
					<span className="inline-block px-4 py-2 bg-amber-100 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 text-sm font-semibold rounded-full mb-4">
						Kesempatan Emas
					</span>
					<h2 className="text-4xl md:text-5xl font-bold text-foreground mb-6">
						Program Beasiswa
					</h2>
					<p className="text-muted-foreground text-lg max-w-2xl mx-auto">
						SMK Diponegoro Karanganyar menyediakan berbagai program beasiswa
						untuk meringankan biaya pendidikan.
					</p>
				</div>

				<div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
					{scholarships.map((scholarship, index) => (
						<div
							key={index}
							ref={(el) => {
								cardsRef.current[index] = el;
							}}
							className="bg-card rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 group border border-border"
						>
							<div className={`h-2 bg-gradient-to-r ${scholarship.color}`} />
							<div className="p-6">
								<div className="flex items-center gap-4 mb-4">
									<div
										className={`w-14 h-14 bg-gradient-to-br ${scholarship.color} rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all duration-300`}
									>
										<scholarship.icon className="w-7 h-7 text-white" />
									</div>
									<div>
										<h3 className="font-bold text-foreground text-lg">
											{scholarship.title}
										</h3>
										<p className="text-sm text-muted-foreground">
											{scholarship.description}
										</p>
									</div>
								</div>

								<div className="space-y-2 mb-4">
									{scholarship.benefits.map((benefit, i) => (
										<div
											key={i}
											className="flex items-center justify-between p-3 bg-secondary/50 rounded-xl"
										>
											<span className="text-sm text-foreground font-medium">
												{benefit.rank}
											</span>
											<span className="text-sm text-primary font-bold">
												{benefit.reward}
											</span>
										</div>
									))}
								</div>

								<p className="text-xs text-muted-foreground italic border-t pt-3">
									*{scholarship.requirement}
								</p>
							</div>
						</div>
					))}
				</div>
			</div>
		</section>
	);
}

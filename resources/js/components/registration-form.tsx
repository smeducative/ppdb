import { Button } from "@/components/ui/button";
import {
	Card,
	CardContent,
	CardDescription,
	CardHeader,
	CardTitle,
} from "@/components/ui/card";
import { Checkbox } from "@/components/ui/checkbox";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { Textarea } from "@/components/ui/textarea";
import { cn } from "@/lib/utils";
import { router, useForm as useInertiaForm, usePage } from "@inertiajs/react";
import confetti from "canvas-confetti";
import gsap from "gsap";
import {
	Award,
	CheckCircle2,
	ChevronLeft,
	ChevronRight,
	GraduationCap,
	Home,
	MessageSquare,
	PartyPopper,
	User,
	Users,
} from "lucide-react";
import { useCallback, useEffect, useRef, useState } from "react";
import { toast } from "sonner";

interface RegistrationFormProps {
	jurusanOptions?: { value: number | string; label: string }[];
}

// Step configuration for the multi-step form wizard
const steps = [
	{ id: 1, title: "Identitas Diri", icon: User },
	{ id: 2, title: "Data Orang Tua", icon: Users },
	{ id: 3, title: "Prestasi", icon: Award },
	{ id: 4, title: "Rekomendasi", icon: MessageSquare },
];

// Default major/department options
const defaultJurusanOptions = [
	{ value: "tjkt", label: "Teknik Jaringan Komputer dan Telekomunikasi" },
	{ value: "at", label: "Smart Farming / Agribisnis Tanaman" },
	{ value: "bdp", label: "Broadcasting dan Perfilman" },
	{ value: "tsm", label: "Teknik Sepeda Motor" },
	{ value: "tkr", label: "Teknik Kendaraan Ringan" },
];

// Competition level options for achievements
const tingkatOptions = [
	{ value: "kabupaten", label: "Kabupaten/Kota" },
	{ value: "karesidenan", label: "Karesidenan" },
	{ value: "provinsi", label: "Provinsi" },
	{ value: "nasional", label: "Nasional" },
];

/**
 * Helper component for displaying form field errors with consistent styling
 */
function FormError({ error }: { error?: string }) {
	if (!error) return null;
	return <p className="mt-1 text-destructive text-sm">{error}</p>;
}

/**
 * Helper component for form fields with label, input, and error display
 */
interface FormFieldProps {
	id: string;
	label: string;
	required?: boolean;
	error?: string;
	children: React.ReactNode;
	className?: string;
}

function FormField({
	id,
	label,
	required = false,
	error,
	children,
	className,
}: FormFieldProps) {
	return (
		<div className={cn("space-y-2", className)}>
			<Label htmlFor={id} className={cn(error && "text-destructive")}>
				{label} {required && "*"}
			</Label>
			{children}
			<FormError error={error} />
		</div>
	);
}

export function RegistrationForm({
	jurusanOptions = defaultJurusanOptions,
}: RegistrationFormProps) {
	const [currentStep, setCurrentStep] = useState(1);
	const [clientErrors, setClientErrors] = useState<Record<string, string>>({});
	const [isSuccess, setIsSuccess] = useState(false);
	const [registrationNumber, setRegistrationNumber] = useState<string>("");

	// Get flash messages from the page props
	const { flash } = usePage<{ flash: { success?: string } }>().props;

	// Check for flash success message on mount (handles page reload after submission)
	useEffect(() => {
		if (flash?.success && flash.success.includes("berhasil mendaftar")) {
			// Extract registration number from flash message
			const match = flash.success.match(/([A-Z]{2,}-\d+-\d+-\d+)/);
			if (match) {
				setRegistrationNumber(match[1]);
			}
			setIsSuccess(true);
			// Trigger confetti after a small delay to ensure DOM is ready
			setTimeout(() => {
				// Fire confetti from multiple angles for a more celebratory effect
				const count = 200;
				const defaults = { origin: { y: 0.7 }, zIndex: 9999 };

				confetti({
					...defaults,
					spread: 26,
					startVelocity: 55,
					particleCount: Math.floor(count * 0.25),
				});
				confetti({
					...defaults,
					spread: 60,
					particleCount: Math.floor(count * 0.2),
				});
				confetti({
					...defaults,
					spread: 100,
					decay: 0.91,
					scalar: 0.8,
					particleCount: Math.floor(count * 0.35),
				});
				confetti({
					...defaults,
					spread: 120,
					startVelocity: 25,
					decay: 0.92,
					scalar: 1.2,
					particleCount: Math.floor(count * 0.1),
				});
				confetti({
					...defaults,
					spread: 120,
					startVelocity: 45,
					particleCount: Math.floor(count * 0.1),
				});

				// Fire from the sides
				setTimeout(() => {
					confetti({
						...defaults,
						particleCount: 50,
						angle: 60,
						spread: 55,
						origin: { x: 0, y: 0.6 },
					});
					confetti({
						...defaults,
						particleCount: 50,
						angle: 120,
						spread: 55,
						origin: { x: 1, y: 0.6 },
					});
				}, 150);
			}, 100);
		}
	}, [flash]);

	// Inertia form hook for handling form state and submission
	const { data, setData, post, processing, errors } = useInertiaForm({
		// Identitas Diri (Personal Identity)
		nama_lengkap: "",
		jenis_kelamin: "",
		tempat_lahir: "",
		tanggal_lahir: "",
		nik: "",
		nisn: "",
		alamat_lengkap: "",
		dukuh: "",
		rt: "",
		rw: "",
		desa_kelurahan: "",
		kecamatan: "",
		kabupaten_kota: "",
		provinsi: "",
		kode_pos: "",
		pilihan_jurusan: "",
		asal_sekolah: "",
		tahun_lulus: "",
		penerima_kip: false,
		no_kip: "",
		no_hp: "",

		// Data Orang Tua (Parent Data)
		nama_ayah: "",
		no_ayah: "",
		pekerjaan_ayah: "",
		nama_ibu: "",
		no_ibu: "",
		pekerjaan_ibu: "",

		// Prestasi Akademik (Academic Achievements)
		peringkat: "",
		hafidz: "",

		// Prestasi Non Akademik (Non-Academic Achievements)
		jenis_lomba: "",
		juara_ke: "",
		juara_tingkat: "",

		// Rekomendasi (Recommendations)
		rekomendasi_mwc: false,
		saran_dari: "",
	});

	const formRef = useRef<HTMLDivElement>(null);
	const cardRef = useRef<HTMLDivElement>(null);

	// Helper function to get error for a field (combines client and server errors)
	const getError = (field: string): string | undefined => {
		return clientErrors[field] || errors[field as keyof typeof errors];
	};

	// Helper function to check if a field has an error
	const hasError = (field: string): boolean => {
		return !!getError(field);
	};

	// Helper function to clear client error when user starts typing
	const clearError = (field: string) => {
		if (clientErrors[field]) {
			const newErrors = { ...clientErrors };
			delete newErrors[field];
			setClientErrors(newErrors);
		}
	};

	// GSAP animation for card entrance
	useEffect(() => {
		const ctx = gsap.context(() => {
			gsap.fromTo(
				cardRef.current,
				{ opacity: 0, y: 40 },
				{ opacity: 1, y: 0, duration: 0.8, ease: "power3.out" },
			);
		});
		return () => ctx.revert();
	}, []);

	// GSAP animation for step transitions
	useEffect(() => {
		gsap.fromTo(
			formRef.current,
			{ opacity: 0, x: 20 },
			{ opacity: 1, x: 0, duration: 0.4, ease: "power2.out" },
		);
	}, [currentStep, formRef]);

	// Validates form fields for the current step
	const validateStep = (step: number) => {
		const newErrors: Record<string, string> = {};

		if (step === 1) {
			const requiredFields = [
				{ key: "nama_lengkap", label: "Nama Lengkap" },
				{ key: "jenis_kelamin", label: "Jenis Kelamin" },
				{ key: "tempat_lahir", label: "Tempat Lahir" },
				{ key: "tanggal_lahir", label: "Tanggal Lahir" },
				{ key: "nik", label: "NIK" },
				{ key: "alamat_lengkap", label: "Alamat Lengkap" },
				{ key: "pilihan_jurusan", label: "Pilihan Jurusan" },
				{ key: "asal_sekolah", label: "Asal Sekolah" },
				{ key: "tahun_lulus", label: "Tahun Lulus" },
				{ key: "no_hp", label: "No. HP" },
			];

			for (const field of requiredFields) {
				// @ts-ignore - Dynamic field access
				if (!data[field.key]) {
					newErrors[field.key] = `${field.label} wajib diisi`;
				}
			}

			// NIK validation: must be exactly 16 digits
			if (data.nik && data.nik.length !== 16) {
				newErrors.nik = "NIK harus terdiri dari 16 digit";
			}
		}

		if (step === 2) {
			if (!data.nama_ayah) {
				newErrors.nama_ayah = "Nama Ayah wajib diisi";
			}
			if (!data.nama_ibu) {
				newErrors.nama_ibu = "Nama Ibu wajib diisi";
			}
		}

		setClientErrors(newErrors);

		if (Object.keys(newErrors).length > 0) {
			const firstError = Object.values(newErrors)[0];
			toast.error(firstError);
			return false;
		}

		return true;
	};

	// Navigate to next step after validation
	const nextStep = (e?: React.MouseEvent) => {
		if (e) e.preventDefault();
		if (validateStep(currentStep)) {
			if (currentStep < 4) setCurrentStep(currentStep + 1);
		}
	};

	// Navigate to previous step
	const prevStep = () => {
		if (currentStep > 1) setCurrentStep(currentStep - 1);
	};

	// Trigger confetti animation
	const fireConfetti = useCallback(() => {
		// Fire confetti from multiple angles for a more celebratory effect
		const count = 200;
		const defaults = {
			origin: { y: 0.7 },
			zIndex: 9999,
		};

		function fire(particleRatio: number, opts: confetti.Options) {
			confetti({
				...defaults,
				...opts,
				particleCount: Math.floor(count * particleRatio),
			});
		}

		// Fire multiple bursts for a more impressive effect
		fire(0.25, { spread: 26, startVelocity: 55 });
		fire(0.2, { spread: 60 });
		fire(0.35, { spread: 100, decay: 0.91, scalar: 0.8 });
		fire(0.1, { spread: 120, startVelocity: 25, decay: 0.92, scalar: 1.2 });
		fire(0.1, { spread: 120, startVelocity: 45 });

		// Fire again from the sides after a short delay
		setTimeout(() => {
			confetti({
				...defaults,
				particleCount: 50,
				angle: 60,
				spread: 55,
				origin: { x: 0, y: 0.6 },
			});
			confetti({
				...defaults,
				particleCount: 50,
				angle: 120,
				spread: 55,
				origin: { x: 1, y: 0.6 },
			});
		}, 150);
	}, []);

	// Handle form submission
	const handleSubmit = (e: React.FormEvent) => {
		e.preventDefault();
		post("/register", {
			onSuccess: (page) => {
				// Extract registration number from flash message if available
				const flashMessage = (page.props as { flash?: { success?: string } })
					.flash?.success;
				if (flashMessage) {
					// Try to extract registration number from the flash message
					const match = flashMessage.match(/([A-Z]{2,}-\d+-\d+-\d+)/);
					if (match) {
						setRegistrationNumber(match[1]);
					}
				}
				// Show success state and trigger confetti
				setIsSuccess(true);
				fireConfetti();
			},
		});
	};

	return (
		<div className="mx-auto px-4 max-w-4xl">
			{/* Success State with Confetti */}
			{isSuccess ? (
				<div className="py-16 text-center">
					<div className="inline-flex justify-center items-center bg-green-100 dark:bg-green-900/30 mb-6 rounded-full w-24 h-24 animate-bounce">
						<PartyPopper className="w-12 h-12 text-green-600 dark:text-green-400" />
					</div>
					<h1 className="mb-4 font-bold text-foreground text-4xl md:text-5xl">
						Selamat! 🎉
					</h1>
					<p className="mb-6 text-muted-foreground text-xl">
						Pendaftaran Anda berhasil disubmit
					</p>

					{registrationNumber && (
						<div className="inline-block bg-primary/10 mb-8 p-6 border border-primary/20 rounded-2xl">
							<p className="mb-2 text-muted-foreground text-sm">
								Nomor Pendaftaran Anda
							</p>
							<p className="font-bold text-primary text-3xl tracking-wider">
								{registrationNumber}
							</p>
						</div>
					)}

					<Card className="shadow-xl mx-auto border-0 rounded-3xl max-w-lg overflow-hidden">
						<CardContent className="p-8">
							<div className="space-y-4">
								<div className="flex items-start gap-3 text-left">
									<CheckCircle2 className="mt-0.5 w-5 h-5 text-green-600 dark:text-green-400 shrink-0" />
									<p className="text-muted-foreground">
										Simpan nomor pendaftaran Anda untuk keperluan daftar ulang
									</p>
								</div>
								<div className="flex items-start gap-3 text-left">
									<CheckCircle2 className="mt-0.5 w-5 h-5 text-green-600 dark:text-green-400 shrink-0" />
									<p className="text-muted-foreground">
										Siapkan berkas-berkas yang diperlukan untuk proses
										selanjutnya
									</p>
								</div>
								<div className="flex items-start gap-3 text-left">
									<CheckCircle2 className="mt-0.5 w-5 h-5 text-green-600 dark:text-green-400 shrink-0" />
									<p className="text-muted-foreground">
										Tim SPMB akan menghubungi Anda melalui No. HP yang terdaftar
									</p>
								</div>
							</div>

							<Button
								className="mt-8 rounded-xl w-full h-12 text-base"
								onClick={() => router.visit("/")}
							>
								<Home className="mr-2 w-4 h-4" />
								Kembali ke Beranda
							</Button>
						</CardContent>
					</Card>
				</div>
			) : (
				<>
					{/* Header */}
					<div className="mb-10 text-center">
						<div className="inline-flex justify-center items-center bg-primary/10 mb-4 rounded-3xl w-20 h-20">
							<GraduationCap className="w-10 h-10 text-primary" />
						</div>
						<h1 className="mb-2 font-bold text-foreground text-3xl md:text-4xl">
							Formulir Pendaftaran
						</h1>
						<p className="text-muted-foreground">
							SPMB, Sistem Penerimaan Murid Baru SMK Diponegoro Karanganyar
							Tahun Ajaran 2026/2027
						</p>
					</div>

					{/* Progress Steps */}
					<div className="mb-8">
						<div className="relative flex justify-between items-center">
							<div className="top-6 right-0 left-0 absolute mx-12 bg-border rounded-full h-1">
								<div
									className="bg-primary rounded-full h-full transition-all duration-500"
									style={{ width: `${((currentStep - 1) / 3) * 100}%` }}
								/>
							</div>

							{steps.map((step) => (
								<div
									key={step.id}
									className="z-10 relative flex flex-col items-center gap-2"
								>
									<div
										className={`w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-300 ${
											step.id === currentStep
												? "bg-primary text-white shadow-lg shadow-primary/30 scale-110"
												: step.id < currentStep
													? "bg-primary/20 text-primary"
													: "bg-white border-2 border-border text-muted-foreground"
										}`}
									>
										{step.id < currentStep ? (
											<CheckCircle2 className="w-6 h-6" />
										) : (
											<step.icon className="w-5 h-5" />
										)}
									</div>
									<span
										className={`text-xs font-medium hidden sm:block ${
											step.id === currentStep
												? "text-primary"
												: "text-muted-foreground"
										}`}
									>
										{step.title}
									</span>
								</div>
							))}
						</div>
					</div>

					{/* Form Card */}
					<Card
						ref={cardRef}
						className="shadow-2xl shadow-primary/5 border-0 rounded-3xl overflow-hidden"
					>
						<CardHeader className="bg-linear-gradient-to-r from-primary/5 to-accent/50 border-b">
							<CardTitle className="flex items-center gap-3 text-xl">
								{(() => {
									const StepIcon = steps[currentStep - 1].icon;
									return <StepIcon className="w-6 h-6 text-primary" />;
								})()}
								{steps[currentStep - 1].title}
							</CardTitle>
							<CardDescription>
								Langkah {currentStep} dari 4 - Isi formulir sesuai data dirimu
							</CardDescription>
						</CardHeader>

						<CardContent className="p-6 md:p-8">
							<form onSubmit={handleSubmit}>
								<div ref={formRef}>
									{/* Step 1: Identitas Diri (Personal Identity) */}
									{currentStep === 1 && (
										<div className="space-y-6">
											<div className="gap-6 grid md:grid-cols-2">
												{/* Nama Lengkap */}
												<FormField
													id="nama_lengkap"
													label="Nama Lengkap"
													required
													error={getError("nama_lengkap")}
													className="md:col-span-2"
												>
													<Input
														id="nama_lengkap"
														placeholder="Nama lengkap sesuai yang tercantum di Ijazah"
														value={data.nama_lengkap}
														onChange={(e) => {
															setData("nama_lengkap", e.target.value);
															clearError("nama_lengkap");
														}}
														aria-invalid={hasError("nama_lengkap")}
														className="rounded-xl h-12"
													/>
												</FormField>

												{/* Jenis Kelamin */}
												<FormField
													id="jenis_kelamin"
													label="Jenis Kelamin"
													required
													error={getError("jenis_kelamin")}
												>
													<RadioGroup
														className="flex gap-4 mt-2"
														value={data.jenis_kelamin}
														onValueChange={(value) => {
															setData("jenis_kelamin", value);
															clearError("jenis_kelamin");
														}}
													>
														<div className="flex items-center space-x-2">
															<RadioGroupItem value="l" id="laki-laki" />
															<Label
																htmlFor="laki-laki"
																className="font-normal cursor-pointer"
															>
																Laki-laki
															</Label>
														</div>
														<div className="flex items-center space-x-2">
															<RadioGroupItem value="p" id="perempuan" />
															<Label
																htmlFor="perempuan"
																className="font-normal cursor-pointer"
															>
																Perempuan
															</Label>
														</div>
													</RadioGroup>
												</FormField>

												{/* Tempat Lahir */}
												<FormField
													id="tempat_lahir"
													label="Tempat Lahir"
													required
													error={getError("tempat_lahir")}
												>
													<Input
														id="tempat_lahir"
														placeholder="Tempat Lahir Peserta"
														value={data.tempat_lahir}
														onChange={(e) => {
															setData("tempat_lahir", e.target.value);
															clearError("tempat_lahir");
														}}
														aria-invalid={hasError("tempat_lahir")}
														className="rounded-xl h-12"
													/>
												</FormField>

												{/* Tanggal Lahir */}
												<FormField
													id="tanggal_lahir"
													label="Tanggal Lahir"
													required
													error={getError("tanggal_lahir")}
												>
													<Input
														id="tanggal_lahir"
														type="date"
														value={data.tanggal_lahir}
														onChange={(e) => {
															setData("tanggal_lahir", e.target.value);
															clearError("tanggal_lahir");
														}}
														aria-invalid={hasError("tanggal_lahir")}
														className="rounded-xl h-12"
													/>
												</FormField>

												{/* NIK */}
												<FormField
													id="nik"
													label="NIK (16 digit)"
													required
													error={getError("nik")}
												>
													<Input
														id="nik"
														placeholder="16 angka NIK sesuai yang tercantum di KK"
														value={data.nik}
														onChange={(e) => {
															setData("nik", e.target.value);
															clearError("nik");
														}}
														aria-invalid={hasError("nik")}
														className="rounded-xl h-12"
														maxLength={16}
													/>
												</FormField>

												{/* NISN */}
												<FormField
													id="nisn"
													label="NISN"
													error={getError("nisn")}
												>
													<Input
														id="nisn"
														placeholder="NISN Peserta"
														value={data.nisn}
														onChange={(e) => setData("nisn", e.target.value)}
														aria-invalid={hasError("nisn")}
														className="rounded-xl h-12"
													/>
												</FormField>

												{/* Alamat Lengkap */}
												<FormField
													id="alamat_lengkap"
													label="Alamat Lengkap"
													required
													error={getError("alamat_lengkap")}
													className="md:col-span-2"
												>
													<Textarea
														id="alamat_lengkap"
														placeholder="Alamat Lengkap Peserta, lihat di KK"
														value={data.alamat_lengkap}
														onChange={(e) => {
															setData("alamat_lengkap", e.target.value);
															clearError("alamat_lengkap");
														}}
														aria-invalid={hasError("alamat_lengkap")}
														className="rounded-xl min-h-[80px]"
													/>
												</FormField>

												{/* Dukuh */}
												<FormField id="dukuh" label="Dukuh">
													<Input
														id="dukuh"
														placeholder="Dukuh"
														value={data.dukuh}
														onChange={(e) => setData("dukuh", e.target.value)}
														className="rounded-xl h-12"
													/>
												</FormField>

												{/* RT/RW */}
												<div className="gap-4 grid grid-cols-2">
													<FormField id="rt" label="RT">
														<Input
															id="rt"
															placeholder="RT"
															value={data.rt}
															onChange={(e) => setData("rt", e.target.value)}
															className="rounded-xl h-12"
														/>
													</FormField>
													<FormField id="rw" label="RW">
														<Input
															id="rw"
															placeholder="RW"
															value={data.rw}
															onChange={(e) => setData("rw", e.target.value)}
															className="rounded-xl h-12"
														/>
													</FormField>
												</div>

												{/* Desa/Kelurahan */}
												<FormField id="desa_kelurahan" label="Desa/Kelurahan">
													<Input
														id="desa_kelurahan"
														placeholder="Desa/Kelurahan"
														value={data.desa_kelurahan}
														onChange={(e) =>
															setData("desa_kelurahan", e.target.value)
														}
														className="rounded-xl h-12"
													/>
												</FormField>

												{/* Kecamatan */}
												<FormField id="kecamatan" label="Kecamatan">
													<Input
														id="kecamatan"
														placeholder="Kecamatan"
														value={data.kecamatan}
														onChange={(e) =>
															setData("kecamatan", e.target.value)
														}
														className="rounded-xl h-12"
													/>
												</FormField>

												{/* Kabupaten/Kota */}
												<FormField id="kabupaten_kota" label="Kabupaten/Kota">
													<Input
														id="kabupaten_kota"
														placeholder="Kabupaten/Kota"
														value={data.kabupaten_kota}
														onChange={(e) =>
															setData("kabupaten_kota", e.target.value)
														}
														className="rounded-xl h-12"
													/>
												</FormField>

												{/* Provinsi */}
												<FormField id="provinsi" label="Provinsi">
													<Input
														id="provinsi"
														placeholder="Provinsi"
														value={data.provinsi}
														onChange={(e) =>
															setData("provinsi", e.target.value)
														}
														className="rounded-xl h-12"
													/>
												</FormField>

												{/* Kode Pos */}
												<FormField id="kode_pos" label="Kode Pos">
													<Input
														id="kode_pos"
														placeholder="Kode Pos"
														value={data.kode_pos}
														onChange={(e) =>
															setData("kode_pos", e.target.value)
														}
														className="rounded-xl h-12"
													/>
												</FormField>

												{/* Pilihan Jurusan */}
												<FormField
													id="pilihan_jurusan"
													label="Pilihan Jurusan"
													required
													error={getError("pilihan_jurusan")}
												>
													<Select
														value={data.pilihan_jurusan}
														onValueChange={(value) => {
															setData("pilihan_jurusan", value);
															clearError("pilihan_jurusan");
														}}
													>
														<SelectTrigger
															className={cn(
																"rounded-xl h-12",
																hasError("pilihan_jurusan") &&
																	"border-destructive ring-destructive/20 ring-[3px]",
															)}
															aria-invalid={hasError("pilihan_jurusan")}
														>
															<SelectValue placeholder="Pilih Jurusan" />
														</SelectTrigger>
														<SelectContent>
															{jurusanOptions.map((j) => (
																<SelectItem
																	key={j.value}
																	value={String(j.value)}
																>
																	{j.label}
																</SelectItem>
															))}
														</SelectContent>
													</Select>
												</FormField>

												{/* Asal Sekolah */}
												<FormField
													id="asal_sekolah"
													label="Asal Sekolah"
													required
													error={getError("asal_sekolah")}
												>
													<Input
														id="asal_sekolah"
														placeholder="Asal Sekolah Peserta"
														value={data.asal_sekolah}
														onChange={(e) => {
															setData("asal_sekolah", e.target.value);
															clearError("asal_sekolah");
														}}
														aria-invalid={hasError("asal_sekolah")}
														className="rounded-xl h-12"
													/>
												</FormField>

												{/* Tahun Lulus */}
												<FormField
													id="tahun_lulus"
													label="Tahun Lulus"
													required
													error={getError("tahun_lulus")}
												>
													<Select
														value={data.tahun_lulus}
														onValueChange={(value) => {
															setData("tahun_lulus", value);
															clearError("tahun_lulus");
														}}
													>
														<SelectTrigger
															className={cn(
																"rounded-xl h-12",
																hasError("tahun_lulus") &&
																	"border-destructive ring-destructive/20 ring-[3px]",
															)}
															aria-invalid={hasError("tahun_lulus")}
														>
															<SelectValue placeholder="Pilih Tahun" />
														</SelectTrigger>
														<SelectContent>
															<SelectItem value="2025">2025</SelectItem>
															<SelectItem value="2024">2024</SelectItem>
															<SelectItem value="2023">2023</SelectItem>
															<SelectItem value="2022">2022</SelectItem>
															<SelectItem value="2021">2021</SelectItem>
														</SelectContent>
													</Select>
												</FormField>

												{/* Penerima KIP Checkbox */}
												<div className="md:col-span-2">
													<div className="flex items-center space-x-2">
														<Checkbox
															id="penerima_kip"
															checked={data.penerima_kip}
															onCheckedChange={(checked) =>
																setData("penerima_kip", checked as boolean)
															}
														/>
														<Label
															htmlFor="penerima_kip"
															className="font-normal cursor-pointer"
														>
															Merupakan peserta Penerima KIP
														</Label>
													</div>
												</div>

												{/* No. KIP (conditional) */}
												{data.penerima_kip && (
													<FormField id="no_kip" label="No. KIP">
														<Input
															id="no_kip"
															placeholder="Nomor KIP"
															value={data.no_kip}
															onChange={(e) =>
																setData("no_kip", e.target.value)
															}
															className="rounded-xl h-12"
														/>
													</FormField>
												)}

												{/* No. HP */}
												<FormField
													id="no_hp"
													label="No. HP"
													required
													error={getError("no_hp")}
												>
													<Input
														id="no_hp"
														type="tel"
														placeholder="No. HP Peserta"
														value={data.no_hp}
														onChange={(e) => {
															setData("no_hp", e.target.value);
															clearError("no_hp");
														}}
														aria-invalid={hasError("no_hp")}
														className="rounded-xl h-12"
													/>
												</FormField>
											</div>
										</div>
									)}

									{/* Step 2: Data Orang Tua (Parent Data) */}
									{currentStep === 2 && (
										<div className="space-y-8">
											{/* Father Data Section */}
											<div>
												<h3 className="flex items-center gap-2 mb-4 font-semibold text-lg">
													<span className="flex justify-center items-center bg-primary/10 rounded-lg w-8 h-8 font-bold text-primary text-sm">
														A
													</span>
													Data Ayah
												</h3>
												<div className="gap-6 grid md:grid-cols-2 pl-10">
													{/* Nama Ayah */}
													<FormField
														id="nama_ayah"
														label="Nama Ayah"
														required
														error={getError("nama_ayah")}
														className="md:col-span-2"
													>
														<Input
															id="nama_ayah"
															placeholder="Nama lengkap ayah"
															value={data.nama_ayah}
															onChange={(e) => {
																setData("nama_ayah", e.target.value);
																clearError("nama_ayah");
															}}
															aria-invalid={hasError("nama_ayah")}
															className="rounded-xl h-12"
														/>
													</FormField>

													{/* No. HP Ayah */}
													<FormField id="no_ayah" label="No. HP Ayah">
														<Input
															id="no_ayah"
															type="tel"
															placeholder="No. HP Ayah"
															value={data.no_ayah}
															onChange={(e) =>
																setData("no_ayah", e.target.value)
															}
															className="rounded-xl h-12"
														/>
													</FormField>

													{/* Pekerjaan Ayah */}
													<FormField id="pekerjaan_ayah" label="Pekerjaan Ayah">
														<Input
															id="pekerjaan_ayah"
															placeholder="Tuliskan pekerjaan ayah"
															value={data.pekerjaan_ayah}
															onChange={(e) =>
																setData("pekerjaan_ayah", e.target.value)
															}
															className="rounded-xl h-12"
														/>
													</FormField>
												</div>
											</div>

											{/* Mother Data Section */}
											<div>
												<h3 className="flex items-center gap-2 mb-4 font-semibold text-lg">
													<span className="flex justify-center items-center bg-primary/10 rounded-lg w-8 h-8 font-bold text-primary text-sm">
														I
													</span>
													Data Ibu
												</h3>
												<div className="gap-6 grid md:grid-cols-2 pl-10">
													{/* Nama Ibu */}
													<FormField
														id="nama_ibu"
														label="Nama Ibu"
														required
														error={getError("nama_ibu")}
														className="md:col-span-2"
													>
														<Input
															id="nama_ibu"
															placeholder="Nama lengkap ibu"
															value={data.nama_ibu}
															onChange={(e) => {
																setData("nama_ibu", e.target.value);
																clearError("nama_ibu");
															}}
															aria-invalid={hasError("nama_ibu")}
															className="rounded-xl h-12"
														/>
													</FormField>

													{/* No. HP Ibu */}
													<FormField id="no_ibu" label="No. HP Ibu">
														<Input
															id="no_ibu"
															type="tel"
															placeholder="No. HP Ibu"
															value={data.no_ibu}
															onChange={(e) =>
																setData("no_ibu", e.target.value)
															}
															className="rounded-xl h-12"
														/>
													</FormField>

													{/* Pekerjaan Ibu */}
													<FormField id="pekerjaan_ibu" label="Pekerjaan Ibu">
														<Input
															id="pekerjaan_ibu"
															placeholder="Tuliskan pekerjaan ibu"
															value={data.pekerjaan_ibu}
															onChange={(e) =>
																setData("pekerjaan_ibu", e.target.value)
															}
															className="rounded-xl h-12"
														/>
													</FormField>
												</div>
											</div>
										</div>
									)}

									{/* Step 3: Prestasi (Achievements) */}
									{currentStep === 3 && (
										<div className="space-y-8">
											<p className="bg-amber-50 dark:bg-amber-950/30 p-4 border border-amber-200 dark:border-amber-800 rounded-xl text-muted-foreground text-sm">
												Jenis beasiswa peserta. Diisi jika peserta memiliki
												beasiswa atau prestasi.
											</p>

											{/* Academic Achievements Section */}
											<div>
												<h3 className="flex items-center gap-2 mb-4 font-semibold text-lg">
													<span className="flex justify-center items-center bg-blue-100 dark:bg-blue-950/50 rounded-lg w-8 h-8 font-bold text-blue-600 dark:text-blue-400 text-sm">
														A
													</span>
													Akademik
												</h3>
												<div className="gap-6 grid md:grid-cols-2 pl-10">
													{/* Peringkat Kelas */}
													<FormField
														id="peringkat"
														label="Peringkat Kelas"
														className="md:col-span-2"
													>
														<Input
															id="peringkat"
															placeholder="Contoh: Kelas 9 / Semester 1 / Peringkat 1"
															value={data.peringkat}
															onChange={(e) =>
																setData("peringkat", e.target.value)
															}
															className="rounded-xl h-12"
														/>
														<p className="text-muted-foreground text-xs">
															Apabila pernah mendapatkan peringkat 1, 2 atau 3
														</p>
													</FormField>

													{/* Hafidz */}
													<FormField
														id="hafidz"
														label="Hafidz / Hafidzoh"
														className="md:col-span-2"
													>
														<Input
															id="hafidz"
															placeholder="Jumlah juz yang dihafal (minimal 1 juz Al-Qur'an)"
															value={data.hafidz}
															onChange={(e) =>
																setData("hafidz", e.target.value)
															}
															className="rounded-xl h-12"
														/>
													</FormField>
												</div>
											</div>

											{/* Non-Academic Achievements Section */}
											<div>
												<h3 className="flex items-center gap-2 mb-4 font-semibold text-lg">
													<span className="flex justify-center items-center bg-amber-100 dark:bg-amber-950/50 rounded-lg w-8 h-8 font-bold text-amber-600 dark:text-amber-400 text-sm">
														N
													</span>
													Non Akademik
												</h3>
												<div className="gap-6 grid md:grid-cols-2 pl-10">
													{/* Jenis Lomba */}
													<FormField
														id="jenis_lomba"
														label="Jenis Lomba"
														className="md:col-span-2"
													>
														<Input
															id="jenis_lomba"
															placeholder="Contoh: Lomba Futsal, Lomba MTQ, dll"
															value={data.jenis_lomba}
															onChange={(e) =>
																setData("jenis_lomba", e.target.value)
															}
															className="rounded-xl h-12"
														/>
													</FormField>

													{/* Juara Ke */}
													<FormField id="juara_ke" label="Juara ke">
														<Select
															value={data.juara_ke}
															onValueChange={(value) =>
																setData("juara_ke", value)
															}
														>
															<SelectTrigger className="rounded-xl h-12">
																<SelectValue placeholder="Pilih Juara" />
															</SelectTrigger>
															<SelectContent>
																<SelectItem value="1">Juara 1</SelectItem>
																<SelectItem value="2">Juara 2</SelectItem>
																<SelectItem value="3">Juara 3</SelectItem>
															</SelectContent>
														</Select>
													</FormField>

													{/* Tingkat */}
													<FormField id="juara_tingkat" label="Tingkat">
														<Select
															value={data.juara_tingkat}
															onValueChange={(value) =>
																setData("juara_tingkat", value)
															}
														>
															<SelectTrigger className="rounded-xl h-12">
																<SelectValue placeholder="Pilih Tingkat" />
															</SelectTrigger>
															<SelectContent>
																{tingkatOptions.map((t) => (
																	<SelectItem key={t.value} value={t.value}>
																		{t.label}
																	</SelectItem>
																))}
															</SelectContent>
														</Select>
														<p className="text-muted-foreground text-xs">
															Kejuaraan minimal tingkat Kabupaten/Kota
														</p>
													</FormField>
												</div>
											</div>
										</div>
									)}

									{/* Step 4: Rekomendasi (Recommendations) */}
									{currentStep === 4 && (
										<div className="space-y-6">
											{/* MWC Recommendation Checkbox */}
											<div className="md:col-span-2">
												<div className="flex items-center space-x-2 bg-secondary/50 p-4 rounded-xl">
													<Checkbox
														id="rekomendasi_mwc"
														checked={data.rekomendasi_mwc}
														onCheckedChange={(checked) =>
															setData("rekomendasi_mwc", checked as boolean)
														}
													/>
													<Label
														htmlFor="rekomendasi_mwc"
														className="font-normal cursor-pointer"
													>
														Merupakan peserta rekomendasi MWC (Majelis Wakil
														Cabang NU Karanganyar)
													</Label>
												</div>
												<p className="mt-2 pl-2 text-muted-foreground text-xs">
													Beasiswa ini diberikan kepada anak di setiap daerah
													Ranting dari hasil rekomendasi/usulan Pengurus Ranting
													NU Se-MWC Karanganyar.
												</p>
											</div>

											{/* Saran Dari */}
											<FormField id="saran_dari" label="Saran Dari">
												<Input
													id="saran_dari"
													placeholder="Contoh: Guru, Teman, Sosial Media, dll"
													value={data.saran_dari}
													onChange={(e) =>
														setData("saran_dari", e.target.value)
													}
													className="rounded-xl h-12"
												/>
											</FormField>

											{/* Registration Requirements Info */}
											<div className="bg-primary/5 mt-8 p-6 border border-primary/20 rounded-2xl">
												<h4 className="mb-3 font-semibold text-foreground">
													Persyaratan Pendaftaran:
												</h4>
												<ul className="space-y-2 text-muted-foreground text-sm">
													<li className="flex items-start gap-2">
														<CheckCircle2 className="mt-0.5 w-4 h-4 text-primary shrink-0" />
														Foto Diri Berwarna Ukuran 3x4 sebanyak 2 lembar
													</li>
													<li className="flex items-start gap-2">
														<CheckCircle2 className="mt-0.5 w-4 h-4 text-primary shrink-0" />
														Fotokopi Kartu Keluarga/KK sebanyak 2 lembar
													</li>
													<li className="flex items-start gap-2">
														<CheckCircle2 className="mt-0.5 w-4 h-4 text-primary shrink-0" />
														Fotokopi Akte Kelahiran sebanyak 2 lembar
													</li>
													<li className="flex items-start gap-2">
														<CheckCircle2 className="mt-0.5 w-4 h-4 text-primary shrink-0" />
														Fotokopi KIP sebanyak 2 lembar (bagi yang punya)
													</li>
													<li className="flex items-start gap-2">
														<CheckCircle2 className="mt-0.5 w-4 h-4 text-primary shrink-0" />
														Fotokopi Ijazah sebanyak 2 lembar (jika sudah
														ada/menyusul)
													</li>
													<li className="flex items-start gap-2">
														<CheckCircle2 className="mt-0.5 w-4 h-4 text-primary shrink-0" />
														Fotokopi Raport/Piagam/Sertifikat bagi yang
														berprestasi
													</li>
												</ul>
											</div>
										</div>
									)}
								</div>

								{/* Navigation Buttons */}
								<div className="flex justify-between mt-8 pt-6 border-t">
									<Button
										type="button"
										variant="outline"
										onClick={prevStep}
										disabled={currentStep === 1}
										className="bg-transparent px-6 rounded-xl"
									>
										<ChevronLeft className="mr-2 w-4 h-4" />
										Sebelumnya
									</Button>

									{currentStep < 4 ? (
										<Button
											key="next-step-btn"
											type="button"
											onClick={nextStep}
											className="px-6 rounded-xl"
										>
											Selanjutnya
											<ChevronRight className="ml-2 w-4 h-4" />
										</Button>
									) : (
										<Button
											key="submit-btn"
											type="submit"
											disabled={processing}
											className="bg-primary hover:bg-primary/90 px-8 rounded-xl"
										>
											<CheckCircle2 className="mr-2 w-4 h-4" />
											{processing ? "Mengirim..." : "Kirim Pendaftaran"}
										</Button>
									)}
								</div>
							</form>
						</CardContent>
					</Card>
				</>
			)}
		</div>
	);
}

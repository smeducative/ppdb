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
import { useForm as useInertiaForm } from "@inertiajs/react";
import gsap from "gsap";
import {
	Award,
	CheckCircle2,
	ChevronLeft,
	ChevronRight,
	GraduationCap,
	MessageSquare,
	User,
	Users,
} from "lucide-react";
import { useEffect, useRef, useState } from "react";
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

// Occupation options for parent data
const pekerjaanOptions = [
	"PNS",
	"TNI/Polri",
	"Wiraswasta",
	"Karyawan Swasta",
	"Petani",
	"Buruh",
	"Pedagang",
	"Lainnya",
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
	return <p className="text-destructive text-sm mt-1">{error}</p>;
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

	// Handle form submission
	const handleSubmit = (e: React.FormEvent) => {
		e.preventDefault();
		post("/register", {
			onSuccess: () => {
				// Handle success (maybe show a different UI or redirect)
			},
		});
	};

	return (
		<div className="max-w-4xl mx-auto px-4">
			{/* Header */}
			<div className="text-center mb-10">
				<div className="inline-flex items-center justify-center w-20 h-20 bg-primary/10 rounded-3xl mb-4">
					<GraduationCap className="w-10 h-10 text-primary" />
				</div>
				<h1 className="text-3xl md:text-4xl font-bold text-foreground mb-2">
					Formulir Pendaftaran
				</h1>
				<p className="text-muted-foreground">
					PPDB SMK Diponegoro Karanganyar Tahun Ajaran 2025/2026
				</p>
			</div>

			{/* Progress Steps */}
			<div className="mb-8">
				<div className="flex items-center justify-between relative">
					<div className="absolute top-6 left-0 right-0 h-1 bg-border rounded-full mx-12">
						<div
							className="h-full bg-primary rounded-full transition-all duration-500"
							style={{ width: `${((currentStep - 1) / 3) * 100}%` }}
						/>
					</div>

					{steps.map((step) => (
						<div
							key={step.id}
							className="relative z-10 flex flex-col items-center gap-2"
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
				className="border-0 shadow-2xl shadow-primary/5 rounded-3xl overflow-hidden"
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
									<div className="grid md:grid-cols-2 gap-6">
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
												className="h-12 rounded-xl"
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
												className="h-12 rounded-xl"
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
												className="h-12 rounded-xl"
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
												className="h-12 rounded-xl"
												maxLength={16}
											/>
										</FormField>

										{/* NISN */}
										<FormField id="nisn" label="NISN" error={getError("nisn")}>
											<Input
												id="nisn"
												placeholder="NISN Peserta"
												value={data.nisn}
												onChange={(e) => setData("nisn", e.target.value)}
												aria-invalid={hasError("nisn")}
												className="h-12 rounded-xl"
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
												className="h-12 rounded-xl"
											/>
										</FormField>

										{/* RT/RW */}
										<div className="grid grid-cols-2 gap-4">
											<FormField id="rt" label="RT">
												<Input
													id="rt"
													placeholder="RT"
													value={data.rt}
													onChange={(e) => setData("rt", e.target.value)}
													className="h-12 rounded-xl"
												/>
											</FormField>
											<FormField id="rw" label="RW">
												<Input
													id="rw"
													placeholder="RW"
													value={data.rw}
													onChange={(e) => setData("rw", e.target.value)}
													className="h-12 rounded-xl"
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
												className="h-12 rounded-xl"
											/>
										</FormField>

										{/* Kecamatan */}
										<FormField id="kecamatan" label="Kecamatan">
											<Input
												id="kecamatan"
												placeholder="Kecamatan"
												value={data.kecamatan}
												onChange={(e) => setData("kecamatan", e.target.value)}
												className="h-12 rounded-xl"
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
												className="h-12 rounded-xl"
											/>
										</FormField>

										{/* Provinsi */}
										<FormField id="provinsi" label="Provinsi">
											<Input
												id="provinsi"
												placeholder="Provinsi"
												value={data.provinsi}
												onChange={(e) => setData("provinsi", e.target.value)}
												className="h-12 rounded-xl"
											/>
										</FormField>

										{/* Kode Pos */}
										<FormField id="kode_pos" label="Kode Pos">
											<Input
												id="kode_pos"
												placeholder="Kode Pos"
												value={data.kode_pos}
												onChange={(e) => setData("kode_pos", e.target.value)}
												className="h-12 rounded-xl"
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
														"h-12 rounded-xl",
														hasError("pilihan_jurusan") &&
															"border-destructive ring-destructive/20 ring-[3px]",
													)}
													aria-invalid={hasError("pilihan_jurusan")}
												>
													<SelectValue placeholder="Pilih Jurusan" />
												</SelectTrigger>
												<SelectContent>
													{jurusanOptions.map((j) => (
														<SelectItem key={j.value} value={String(j.value)}>
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
												className="h-12 rounded-xl"
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
														"h-12 rounded-xl",
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
													onChange={(e) => setData("no_kip", e.target.value)}
													className="h-12 rounded-xl"
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
												className="h-12 rounded-xl"
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
										<h3 className="text-lg font-semibold mb-4 flex items-center gap-2">
											<span className="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-sm text-primary font-bold">
												A
											</span>
											Data Ayah
										</h3>
										<div className="grid md:grid-cols-2 gap-6 pl-10">
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
													className="h-12 rounded-xl"
												/>
											</FormField>

											{/* No. HP Ayah */}
											<FormField id="no_ayah" label="No. HP Ayah">
												<Input
													id="no_ayah"
													type="tel"
													placeholder="No. HP Ayah"
													value={data.no_ayah}
													onChange={(e) => setData("no_ayah", e.target.value)}
													className="h-12 rounded-xl"
												/>
											</FormField>

											{/* Pekerjaan Ayah */}
											<FormField id="pekerjaan_ayah" label="Pekerjaan Ayah">
												<Select
													value={data.pekerjaan_ayah}
													onValueChange={(value) =>
														setData("pekerjaan_ayah", value)
													}
												>
													<SelectTrigger className="h-12 rounded-xl">
														<SelectValue placeholder="Pilih Pekerjaan" />
													</SelectTrigger>
													<SelectContent>
														{pekerjaanOptions.map((p) => (
															<SelectItem key={p} value={p}>
																{p}
															</SelectItem>
														))}
													</SelectContent>
												</Select>
											</FormField>
										</div>
									</div>

									{/* Mother Data Section */}
									<div>
										<h3 className="text-lg font-semibold mb-4 flex items-center gap-2">
											<span className="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-sm text-primary font-bold">
												I
											</span>
											Data Ibu
										</h3>
										<div className="grid md:grid-cols-2 gap-6 pl-10">
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
													className="h-12 rounded-xl"
												/>
											</FormField>

											{/* No. HP Ibu */}
											<FormField id="no_ibu" label="No. HP Ibu">
												<Input
													id="no_ibu"
													type="tel"
													placeholder="No. HP Ibu"
													value={data.no_ibu}
													onChange={(e) => setData("no_ibu", e.target.value)}
													className="h-12 rounded-xl"
												/>
											</FormField>

											{/* Pekerjaan Ibu */}
											<FormField id="pekerjaan_ibu" label="Pekerjaan Ibu">
												<Select
													value={data.pekerjaan_ibu}
													onValueChange={(value) =>
														setData("pekerjaan_ibu", value)
													}
												>
													<SelectTrigger className="h-12 rounded-xl">
														<SelectValue placeholder="Pilih Pekerjaan" />
													</SelectTrigger>
													<SelectContent>
														{pekerjaanOptions.map((p) => (
															<SelectItem key={p} value={p}>
																{p}
															</SelectItem>
														))}
													</SelectContent>
												</Select>
											</FormField>
										</div>
									</div>
								</div>
							)}

							{/* Step 3: Prestasi (Achievements) */}
							{currentStep === 3 && (
								<div className="space-y-8">
									<p className="text-sm text-muted-foreground bg-amber-50 dark:bg-amber-950/30 p-4 rounded-xl border border-amber-200 dark:border-amber-800">
										Jenis beasiswa peserta. Diisi jika peserta memiliki beasiswa
										atau prestasi.
									</p>

									{/* Academic Achievements Section */}
									<div>
										<h3 className="text-lg font-semibold mb-4 flex items-center gap-2">
											<span className="w-8 h-8 bg-blue-100 dark:bg-blue-950/50 rounded-lg flex items-center justify-center text-sm text-blue-600 dark:text-blue-400 font-bold">
												A
											</span>
											Akademik
										</h3>
										<div className="grid md:grid-cols-2 gap-6 pl-10">
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
													onChange={(e) => setData("peringkat", e.target.value)}
													className="h-12 rounded-xl"
												/>
												<p className="text-xs text-muted-foreground">
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
													onChange={(e) => setData("hafidz", e.target.value)}
													className="h-12 rounded-xl"
												/>
											</FormField>
										</div>
									</div>

									{/* Non-Academic Achievements Section */}
									<div>
										<h3 className="text-lg font-semibold mb-4 flex items-center gap-2">
											<span className="w-8 h-8 bg-amber-100 dark:bg-amber-950/50 rounded-lg flex items-center justify-center text-sm text-amber-600 dark:text-amber-400 font-bold">
												N
											</span>
											Non Akademik
										</h3>
										<div className="grid md:grid-cols-2 gap-6 pl-10">
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
													className="h-12 rounded-xl"
												/>
											</FormField>

											{/* Juara Ke */}
											<FormField id="juara_ke" label="Juara ke">
												<Select
													value={data.juara_ke}
													onValueChange={(value) => setData("juara_ke", value)}
												>
													<SelectTrigger className="h-12 rounded-xl">
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
													<SelectTrigger className="h-12 rounded-xl">
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
												<p className="text-xs text-muted-foreground">
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
										<div className="flex items-center space-x-2 p-4 bg-secondary/50 rounded-xl">
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
												Merupakan peserta rekomendasi MWC (Majelis Wakil Cabang
												NU Karanganyar)
											</Label>
										</div>
										<p className="text-xs text-muted-foreground mt-2 pl-2">
											Beasiswa ini diberikan kepada anak di setiap daerah
											Ranting dari hasil rekomendasi/usulan Pengurus Ranting NU
											Se-MWC Karanganyar.
										</p>
									</div>

									{/* Saran Dari */}
									<FormField id="saran_dari" label="Saran Dari">
										<Input
											id="saran_dari"
											placeholder="Contoh: Guru, Teman, Sosial Media, dll"
											value={data.saran_dari}
											onChange={(e) => setData("saran_dari", e.target.value)}
											className="h-12 rounded-xl"
										/>
									</FormField>

									{/* Registration Requirements Info */}
									<div className="bg-primary/5 p-6 rounded-2xl border border-primary/20 mt-8">
										<h4 className="font-semibold text-foreground mb-3">
											Persyaratan Pendaftaran:
										</h4>
										<ul className="space-y-2 text-sm text-muted-foreground">
											<li className="flex items-start gap-2">
												<CheckCircle2 className="w-4 h-4 text-primary mt-0.5 shrink-0" />
												Foto Diri Berwarna Ukuran 3x4 sebanyak 2 lembar
											</li>
											<li className="flex items-start gap-2">
												<CheckCircle2 className="w-4 h-4 text-primary mt-0.5 shrink-0" />
												Fotokopi Kartu Keluarga/KK sebanyak 2 lembar
											</li>
											<li className="flex items-start gap-2">
												<CheckCircle2 className="w-4 h-4 text-primary mt-0.5 shrink-0" />
												Fotokopi Akte Kelahiran sebanyak 2 lembar
											</li>
											<li className="flex items-start gap-2">
												<CheckCircle2 className="w-4 h-4 text-primary mt-0.5 shrink-0" />
												Fotokopi KIP sebanyak 2 lembar (bagi yang punya)
											</li>
											<li className="flex items-start gap-2">
												<CheckCircle2 className="w-4 h-4 text-primary mt-0.5 shrink-0" />
												Fotokopi Ijazah sebanyak 2 lembar (jika sudah
												ada/menyusul)
											</li>
											<li className="flex items-start gap-2">
												<CheckCircle2 className="w-4 h-4 text-primary mt-0.5 shrink-0" />
												Fotokopi Raport/Piagam/Sertifikat bagi yang berprestasi
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
								className="rounded-xl px-6 bg-transparent"
							>
								<ChevronLeft className="w-4 h-4 mr-2" />
								Sebelumnya
							</Button>

							{currentStep < 4 ? (
								<Button
									key="next-step-btn"
									type="button"
									onClick={nextStep}
									className="rounded-xl px-6"
								>
									Selanjutnya
									<ChevronRight className="w-4 h-4 ml-2" />
								</Button>
							) : (
								<Button
									key="submit-btn"
									type="submit"
									disabled={processing}
									className="rounded-xl px-8 bg-primary hover:bg-primary/90"
								>
									<CheckCircle2 className="w-4 h-4 mr-2" />
									{processing ? "Mengirim..." : "Kirim Pendaftaran"}
								</Button>
							)}
						</div>
					</form>
				</CardContent>
			</Card>
		</div>
	);
}

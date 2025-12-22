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
import { useForm } from "@inertiajs/react";
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

interface RegistrationFormProps {
	jurusanOptions?: { value: number | string; label: string }[];
}

const steps = [
	{ id: 1, title: "Identitas Diri", icon: User },
	{ id: 2, title: "Data Orang Tua", icon: Users },
	{ id: 3, title: "Prestasi", icon: Award },
	{ id: 4, title: "Rekomendasi", icon: MessageSquare },
];

const defaultJurusanOptions = [
	{ value: "tjkt", label: "Teknik Jaringan Komputer dan Telekomunikasi" },
	{ value: "at", label: "Smart Farming / Agribisnis Tanaman" },
	{ value: "bdp", label: "Broadcasting dan Perfilman" },
	{ value: "tsm", label: "Teknik Sepeda Motor" },
	{ value: "tkr", label: "Teknik Kendaraan Ringan" },
];

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

const tingkatOptions = [
	{ value: "kabupaten", label: "Kabupaten/Kota" },
	{ value: "karesidenan", label: "Karesidenan" },
	{ value: "provinsi", label: "Provinsi" },
	{ value: "nasional", label: "Nasional" },
];

export function RegistrationForm({
	jurusanOptions = defaultJurusanOptions,
}: RegistrationFormProps) {
	const [currentStep, setCurrentStep] = useState(1);
	const { data, setData, post, processing, errors } = useForm({
		// Identitas Diri
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

		// Data Orang Tua
		nama_ayah: "",
		no_ayah: "",
		pekerjaan_ayah: "",
		nama_ibu: "",
		no_ibu: "",
		pekerjaan_ibu: "",

		// Prestasi Akademik
		peringkat: "",
		hafidz: "",

		// Prestasi Non Akademik
		jenis_lomba: "",
		juara_ke: "",
		juara_tingkat: "",

		// Rekomendasi
		rekomendasi_mwc: false,
		saran_dari: "",
	});

	const formRef = useRef<HTMLDivElement>(null);
	const cardRef = useRef<HTMLDivElement>(null);

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

	useEffect(() => {
		gsap.fromTo(
			formRef.current,
			{ opacity: 0, x: 20 },
			{ opacity: 1, x: 0, duration: 0.4, ease: "power2.out" },
		);
	}, [currentStep, formRef]);

	const nextStep = () => {
		if (currentStep < 4) setCurrentStep(currentStep + 1);
	};

	const prevStep = () => {
		if (currentStep > 1) setCurrentStep(currentStep - 1);
	};

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
				<CardHeader className="bg-linear-to-r from-primary/5 to-accent/50 border-b">
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
							{/* Step 1: Identitas Diri */}
							{currentStep === 1 && (
								<div className="space-y-6">
									<div className="grid md:grid-cols-2 gap-6">
										<div className="md:col-span-2">
											<Label htmlFor="nama_lengkap">Nama Lengkap *</Label>
											<Input
												id="nama_lengkap"
												placeholder="Nama lengkap sesuai yang tercantum di Ijazah"
												value={data.nama_lengkap}
												onChange={(e) =>
													setData("nama_lengkap", e.target.value)
												}
												className="mt-2 h-12 rounded-xl"
												required
											/>
											{errors.nama_lengkap && (
												<p className="text-red-500 text-xs mt-1">
													{errors.nama_lengkap}
												</p>
											)}
										</div>

										<div>
											<Label>Jenis Kelamin *</Label>
											<RadioGroup
												className="flex gap-4 mt-2"
												value={data.jenis_kelamin}
												onValueChange={(value) =>
													setData("jenis_kelamin", value)
												}
											>
												<div className="flex items-center space-x-2">
													<RadioGroupItem value="laki-laki" id="laki-laki" />
													<Label
														htmlFor="laki-laki"
														className="font-normal cursor-pointer"
													>
														Laki-laki
													</Label>
												</div>
												<div className="flex items-center space-x-2">
													<RadioGroupItem value="perempuan" id="perempuan" />
													<Label
														htmlFor="perempuan"
														className="font-normal cursor-pointer"
													>
														Perempuan
													</Label>
												</div>
											</RadioGroup>
											{errors.jenis_kelamin && (
												<p className="text-red-500 text-xs mt-1">
													{errors.jenis_kelamin}
												</p>
											)}
										</div>

										<div>
											<Label htmlFor="tempat_lahir">Tempat Lahir *</Label>
											<Input
												id="tempat_lahir"
												placeholder="Tempat Lahir Peserta"
												value={data.tempat_lahir}
												onChange={(e) =>
													setData("tempat_lahir", e.target.value)
												}
												className="mt-2 h-12 rounded-xl"
												required
											/>
											{errors.tempat_lahir && (
												<p className="text-red-500 text-xs mt-1">
													{errors.tempat_lahir}
												</p>
											)}
										</div>

										<div>
											<Label htmlFor="tanggal_lahir">Tanggal Lahir *</Label>
											<Input
												id="tanggal_lahir"
												type="date"
												value={data.tanggal_lahir}
												onChange={(e) =>
													setData("tanggal_lahir", e.target.value)
												}
												className="mt-2 h-12 rounded-xl"
												required
											/>
											{errors.tanggal_lahir && (
												<p className="text-red-500 text-xs mt-1">
													{errors.tanggal_lahir}
												</p>
											)}
										</div>

										<div>
											<Label htmlFor="nik">NIK (16 digit) *</Label>
											<Input
												id="nik"
												placeholder="16 angka NIK sesuai yang tercantum di KK"
												value={data.nik}
												onChange={(e) => setData("nik", e.target.value)}
												className="mt-2 h-12 rounded-xl"
												maxLength={16}
												required
											/>
											{errors.nik && (
												<p className="text-red-500 text-xs mt-1">
													{errors.nik}
												</p>
											)}
										</div>

										<div>
											<Label htmlFor="nisn">NISN</Label>
											<Input
												id="nisn"
												placeholder="NISN Peserta"
												value={data.nisn}
												onChange={(e) => setData("nisn", e.target.value)}
												className="mt-2 h-12 rounded-xl"
											/>
											{errors.nisn && (
												<p className="text-red-500 text-xs mt-1">
													{errors.nisn}
												</p>
											)}
										</div>

										<div className="md:col-span-2">
											<Label htmlFor="alamat_lengkap">Alamat Lengkap *</Label>
											<Textarea
												id="alamat_lengkap"
												placeholder="Alamat Lengkap Peserta, lihat di KK"
												value={data.alamat_lengkap}
												onChange={(e) =>
													setData("alamat_lengkap", e.target.value)
												}
												className="mt-2 rounded-xl min-h-[80px]"
												required
											/>
											{errors.alamat_lengkap && (
												<p className="text-red-500 text-xs mt-1">
													{errors.alamat_lengkap}
												</p>
											)}
										</div>

										<div>
											<Label htmlFor="dukuh">Dukuh</Label>
											<Input
												id="dukuh"
												placeholder="Dukuh"
												value={data.dukuh}
												onChange={(e) => setData("dukuh", e.target.value)}
												className="mt-2 h-12 rounded-xl"
											/>
										</div>

										<div className="grid grid-cols-2 gap-4">
											<div>
												<Label htmlFor="rt">RT</Label>
												<Input
													id="rt"
													placeholder="RT"
													value={data.rt}
													onChange={(e) => setData("rt", e.target.value)}
													className="mt-2 h-12 rounded-xl"
												/>
											</div>
											<div>
												<Label htmlFor="rw">RW</Label>
												<Input
													id="rw"
													placeholder="RW"
													value={data.rw}
													onChange={(e) => setData("rw", e.target.value)}
													className="mt-2 h-12 rounded-xl"
												/>
											</div>
										</div>

										<div>
											<Label htmlFor="desa_kelurahan">Desa/Kelurahan</Label>
											<Input
												id="desa_kelurahan"
												placeholder="Desa/Kelurahan"
												value={data.desa_kelurahan}
												onChange={(e) =>
													setData("desa_kelurahan", e.target.value)
												}
												className="mt-2 h-12 rounded-xl"
											/>
										</div>

										<div>
											<Label htmlFor="kecamatan">Kecamatan</Label>
											<Input
												id="kecamatan"
												placeholder="Kecamatan"
												value={data.kecamatan}
												onChange={(e) => setData("kecamatan", e.target.value)}
												className="mt-2 h-12 rounded-xl"
											/>
										</div>

										<div>
											<Label htmlFor="kabupaten_kota">Kabupaten/Kota</Label>
											<Input
												id="kabupaten_kota"
												placeholder="Kabupaten/Kota"
												value={data.kabupaten_kota}
												onChange={(e) =>
													setData("kabupaten_kota", e.target.value)
												}
												className="mt-2 h-12 rounded-xl"
											/>
										</div>

										<div>
											<Label htmlFor="provinsi">Provinsi</Label>
											<Input
												id="provinsi"
												placeholder="Provinsi"
												value={data.provinsi}
												onChange={(e) => setData("provinsi", e.target.value)}
												className="mt-2 h-12 rounded-xl"
											/>
										</div>

										<div>
											<Label htmlFor="kode_pos">Kode Pos</Label>
											<Input
												id="kode_pos"
												placeholder="Kode Pos"
												value={data.kode_pos}
												onChange={(e) => setData("kode_pos", e.target.value)}
												className="mt-2 h-12 rounded-xl"
											/>
										</div>

										<div>
											<Label htmlFor="pilihan_jurusan">Pilihan Jurusan *</Label>
											<Select
												value={data.pilihan_jurusan}
												onValueChange={(value) =>
													setData("pilihan_jurusan", value)
												}
											>
												<SelectTrigger className="mt-2 h-12 rounded-xl">
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
											{errors.pilihan_jurusan && (
												<p className="text-red-500 text-xs mt-1">
													{errors.pilihan_jurusan}
												</p>
											)}
										</div>

										<div>
											<Label htmlFor="asal_sekolah">Asal Sekolah *</Label>
											<Input
												id="asal_sekolah"
												placeholder="Asal Sekolah Peserta"
												value={data.asal_sekolah}
												onChange={(e) =>
													setData("asal_sekolah", e.target.value)
												}
												className="mt-2 h-12 rounded-xl"
												required
											/>
											{errors.asal_sekolah && (
												<p className="text-red-500 text-xs mt-1">
													{errors.asal_sekolah}
												</p>
											)}
										</div>

										<div>
											<Label htmlFor="tahun_lulus">Tahun Lulus *</Label>
											<Select
												value={data.tahun_lulus}
												onValueChange={(value) => setData("tahun_lulus", value)}
											>
												<SelectTrigger className="mt-2 h-12 rounded-xl">
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
											{errors.tahun_lulus && (
												<p className="text-red-500 text-xs mt-1">
													{errors.tahun_lulus}
												</p>
											)}
										</div>

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

										{data.penerima_kip && (
											<div>
												<Label htmlFor="no_kip">No. KIP</Label>
												<Input
													id="no_kip"
													placeholder="Nomor KIP"
													value={data.no_kip}
													onChange={(e) => setData("no_kip", e.target.value)}
													className="mt-2 h-12 rounded-xl"
												/>
											</div>
										)}

										<div>
											<Label htmlFor="no_hp">No. HP *</Label>
											<Input
												id="no_hp"
												type="tel"
												placeholder="No. HP Peserta"
												value={data.no_hp}
												onChange={(e) => setData("no_hp", e.target.value)}
												className="mt-2 h-12 rounded-xl"
												required
											/>
											{errors.no_hp && (
												<p className="text-red-500 text-xs mt-1">
													{errors.no_hp}
												</p>
											)}
										</div>
									</div>
								</div>
							)}

							{/* Step 2: Data Orang Tua */}
							{currentStep === 2 && (
								<div className="space-y-8">
									<div>
										<h3 className="text-lg font-semibold mb-4 flex items-center gap-2">
											<span className="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-sm text-primary font-bold">
												A
											</span>
											Data Ayah
										</h3>
										<div className="grid md:grid-cols-2 gap-6 pl-10">
											<div className="md:col-span-2">
												<Label htmlFor="nama_ayah">Nama Ayah *</Label>
												<Input
													id="nama_ayah"
													placeholder="Nama lengkap ayah"
													value={data.nama_ayah}
													onChange={(e) => setData("nama_ayah", e.target.value)}
													className="mt-2 h-12 rounded-xl"
													required
												/>
												{errors.nama_ayah && (
													<p className="text-red-500 text-xs mt-1">
														{errors.nama_ayah}
													</p>
												)}
											</div>
											<div>
												<Label htmlFor="no_ayah">No. HP Ayah</Label>
												<Input
													id="no_ayah"
													type="tel"
													placeholder="No. HP Ayah"
													value={data.no_ayah}
													onChange={(e) => setData("no_ayah", e.target.value)}
													className="mt-2 h-12 rounded-xl"
												/>
											</div>
											<div>
												<Label htmlFor="pekerjaan_ayah">Pekerjaan Ayah</Label>
												<Select
													value={data.pekerjaan_ayah}
													onValueChange={(value) =>
														setData("pekerjaan_ayah", value)
													}
												>
													<SelectTrigger className="mt-2 h-12 rounded-xl">
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
											</div>
										</div>
									</div>

									<div>
										<h3 className="text-lg font-semibold mb-4 flex items-center gap-2">
											<span className="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center text-sm text-primary font-bold">
												I
											</span>
											Data Ibu
										</h3>
										<div className="grid md:grid-cols-2 gap-6 pl-10">
											<div className="md:col-span-2">
												<Label htmlFor="nama_ibu">Nama Ibu *</Label>
												<Input
													id="nama_ibu"
													placeholder="Nama lengkap ibu"
													value={data.nama_ibu}
													onChange={(e) => setData("nama_ibu", e.target.value)}
													className="mt-2 h-12 rounded-xl"
													required
												/>
												{errors.nama_ibu && (
													<p className="text-red-500 text-xs mt-1">
														{errors.nama_ibu}
													</p>
												)}
											</div>
											<div>
												<Label htmlFor="no_ibu">No. HP Ibu</Label>
												<Input
													id="no_ibu"
													type="tel"
													placeholder="No. HP Ibu"
													value={data.no_ibu}
													onChange={(e) => setData("no_ibu", e.target.value)}
													className="mt-2 h-12 rounded-xl"
												/>
											</div>
											<div>
												<Label htmlFor="pekerjaan_ibu">Pekerjaan Ibu</Label>
												<Select
													value={data.pekerjaan_ibu}
													onValueChange={(value) =>
														setData("pekerjaan_ibu", value)
													}
												>
													<SelectTrigger className="mt-2 h-12 rounded-xl">
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
											</div>
										</div>
									</div>
								</div>
							)}

							{/* Step 3: Prestasi */}
							{currentStep === 3 && (
								<div className="space-y-8">
									<p className="text-sm text-muted-foreground bg-amber-50 p-4 rounded-xl border border-amber-200">
										Jenis beasiswa peserta. Diisi jika peserta memiliki beasiswa
										atau prestasi.
									</p>

									<div>
										<h3 className="text-lg font-semibold mb-4 flex items-center gap-2">
											<span className="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-sm text-blue-600 font-bold">
												A
											</span>
											Akademik
										</h3>
										<div className="grid md:grid-cols-2 gap-6 pl-10">
											<div className="md:col-span-2">
												<Label htmlFor="peringkat">Peringkat Kelas</Label>
												<Input
													id="peringkat"
													placeholder="Contoh: Kelas 9 / Semester 1 / Peringkat 1"
													value={data.peringkat}
													onChange={(e) => setData("peringkat", e.target.value)}
													className="mt-2 h-12 rounded-xl"
												/>
												<p className="text-xs text-muted-foreground mt-1">
													Apabila pernah mendapatkan peringkat 1, 2 atau 3
												</p>
											</div>
											<div className="md:col-span-2">
												<Label htmlFor="hafidz">Hafidz / Hafidzoh</Label>
												<Input
													id="hafidz"
													placeholder="Jumlah juz yang dihafal (minimal 1 juz Al-Qur'an)"
													value={data.hafidz}
													onChange={(e) => setData("hafidz", e.target.value)}
													className="mt-2 h-12 rounded-xl"
												/>
											</div>
										</div>
									</div>

									<div>
										<h3 className="text-lg font-semibold mb-4 flex items-center gap-2">
											<span className="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center text-sm text-amber-600 font-bold">
												N
											</span>
											Non Akademik
										</h3>
										<div className="grid md:grid-cols-2 gap-6 pl-10">
											<div className="md:col-span-2">
												<Label htmlFor="jenis_lomba">Jenis Lomba</Label>
												<Input
													id="jenis_lomba"
													placeholder="Contoh: Lomba Futsal, Lomba MTQ, dll"
													value={data.jenis_lomba}
													onChange={(e) =>
														setData("jenis_lomba", e.target.value)
													}
													className="mt-2 h-12 rounded-xl"
												/>
											</div>
											<div>
												<Label htmlFor="juara_ke">Juara ke</Label>
												<Select
													value={data.juara_ke}
													onValueChange={(value) => setData("juara_ke", value)}
												>
													<SelectTrigger className="mt-2 h-12 rounded-xl">
														<SelectValue placeholder="Pilih Juara" />
													</SelectTrigger>
													<SelectContent>
														<SelectItem value="1">Juara 1</SelectItem>
														<SelectItem value="2">Juara 2</SelectItem>
														<SelectItem value="3">Juara 3</SelectItem>
													</SelectContent>
												</Select>
											</div>
											<div>
												<Label htmlFor="juara_tingkat">Tingkat</Label>
												<Select
													value={data.juara_tingkat}
													onValueChange={(value) =>
														setData("juara_tingkat", value)
													}
												>
													<SelectTrigger className="mt-2 h-12 rounded-xl">
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
												<p className="text-xs text-muted-foreground mt-1">
													Kejuaraan minimal tingkat Kabupaten/Kota
												</p>
											</div>
										</div>
									</div>
								</div>
							)}

							{/* Step 4: Rekomendasi */}
							{currentStep === 4 && (
								<div className="space-y-6">
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

									<div>
										<Label htmlFor="saran_dari">Saran Dari</Label>
										<Input
											id="saran_dari"
											placeholder="Contoh: Guru, Teman, Sosial Media, dll"
											value={data.saran_dari}
											onChange={(e) => setData("saran_dari", e.target.value)}
											className="mt-2 h-12 rounded-xl"
										/>
									</div>

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
									type="button"
									onClick={nextStep}
									className="rounded-xl px-6"
								>
									Selanjutnya
									<ChevronRight className="w-4 h-4 ml-2" />
								</Button>
							) : (
								<Button
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

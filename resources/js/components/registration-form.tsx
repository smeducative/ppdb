import {
	AlertDialog,
	AlertDialogAction,
	AlertDialogCancel,
	AlertDialogContent,
	AlertDialogDescription,
	AlertDialogFooter,
	AlertDialogHeader,
	AlertDialogTitle,
	AlertDialogTrigger,
} from "@/components/ui/alert-dialog";
import { Button } from "@/components/ui/button";
import {
	Card,
	CardContent,
	CardDescription,
	CardHeader,
	CardTitle,
} from "@/components/ui/card";
import { Checkbox } from "@/components/ui/checkbox";
import {
	Command,
	CommandEmpty,
	CommandGroup,
	CommandInput,
	CommandItem,
	CommandList,
} from "@/components/ui/command";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
	Popover,
	PopoverContent,
	PopoverTrigger,
} from "@/components/ui/popover";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { Textarea } from "@/components/ui/textarea";
import { SCHOOLS } from "@/data/schools";
import { cn } from "@/lib/utils";
import { router, useForm as useInertiaForm, usePage } from "@inertiajs/react";
import confetti from "canvas-confetti";
import gsap from "gsap";
import {
	Award,
	Check,
	CheckCircle2,
	ChevronLeft,
	ChevronRight,
	ChevronsUpDown,
	ClipboardList,
	GraduationCap,
	Home,
	IdCard,
	Info,
	MapPin,
	MessageSquare,
	PartyPopper,
	School,
	ShieldAlert,
	ShieldCheck,
	Trash2,
	Trophy,
	User,
	Users,
} from "lucide-react";
import type { LucideIcon } from "lucide-react";
import { useCallback, useEffect, useRef, useState } from "react";
import type { ReactNode } from "react";
import { toast } from "sonner";

interface RegistrationFormProps {
	jurusanOptions?: { value: number | string; label: string }[];
	initialData?: any;
	submitUrl?: string;
	method?: "post" | "put";
	mode?: "landing" | "admin";
	showDelete?: boolean;
	onDelete?: () => void;
	title?: string;
	description?: string;
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

const tingkatOptions = [
	{ value: "Kabupaten/Kota", label: "Kabupaten/Kota" },
	{ value: "Karesidenan", label: "Karesidenan" },
	{ value: "Provinsi", label: "Provinsi" },
	{ value: "Nasional", label: "Nasional" },
];

function FormError({ error }: { error?: string }) {
	if (!error) return null;
	return <p className="mt-1 text-sm text-destructive">{error}</p>;
}

interface FormFieldProps {
	id: string;
	label: string;
	required?: boolean;
	error?: string;
	children: ReactNode;
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

function SectionCard({
	icon: Icon,
	title,
	description,
	children,
	className,
}: {
	icon: LucideIcon;
	title: string;
	description?: string;
	children: ReactNode;
	className?: string;
}) {
	return (
		<Card className={className}>
			<CardHeader className="border-b pb-4">
				<div className="flex items-start gap-3">
					<div className="flex size-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary">
						<Icon className="size-4" />
					</div>
					<div className="min-w-0 space-y-1">
						<CardTitle className="text-base">{title}</CardTitle>
						{description ? (
							<CardDescription>{description}</CardDescription>
						) : null}
					</div>
				</div>
			</CardHeader>
			<CardContent className="pt-4">
				<div className="grid grid-cols-1 gap-4 sm:grid-cols-2">{children}</div>
			</CardContent>
		</Card>
	);
}

export function RegistrationForm({
	jurusanOptions = defaultJurusanOptions,
	initialData,
	submitUrl = "/register",
	method = "post",
	mode = "landing",
	showDelete = false,
	onDelete,
	title,
	description,
}: RegistrationFormProps) {
	const [currentStep, setCurrentStep] = useState(1);
	const [clientErrors, setClientErrors] = useState<Record<string, string>>({});
	const [isSuccess, setIsSuccess] = useState(false);
	const [isRejected, setIsRejected] = useState(false);
	const [registrationNumber, setRegistrationNumber] = useState<string>("");

	const [openSchool, setOpenSchool] = useState(false);
	const [schoolSearch, setSchoolSearch] = useState("");

	const { flash } = usePage<any>().props;

	const isAdmin = mode === "admin";

	useEffect(() => {
		if (isAdmin) {
			return;
		}

		const noPendaftaranRegex = /([A-Z]{2,}-\d+-\d+-\d+)/;

		if (flash?.warning) {
			const match = flash.warning.match(noPendaftaranRegex);
			if (match) {
				setRegistrationNumber(match[1]);
			}
			setIsRejected(true);
			return;
		}

		if (flash?.success && flash.success.includes("berhasil mendaftar")) {
			const match = flash.success.match(noPendaftaranRegex);
			if (match) {
				setRegistrationNumber(match[1]);
			}
			setIsSuccess(true);
			setTimeout(() => {
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
	}, [flash, isAdmin]);

	const {
		data,
		setData,
		post,
		put,
		processing,
		errors,
		reset,
		clearErrors: clearInertiaErrors,
	} = useInertiaForm({
		nama_lengkap: initialData?.nama_lengkap || "",
		jenis_kelamin: initialData?.jenis_kelamin || "",
		tempat_lahir: initialData?.tempat_lahir || "",
		tanggal_lahir: initialData?.tanggal_lahir || "",
		nik: initialData?.nik || "",
		nisn: initialData?.nisn || "",
		alamat_lengkap: initialData?.alamat_lengkap || "",
		dukuh: initialData?.dukuh || "",
		rt: initialData?.rt || "",
		rw: initialData?.rw || "",
		desa_kelurahan: initialData?.desa_kelurahan || "",
		kecamatan: initialData?.kecamatan || "",
		kabupaten_kota: initialData?.kabupaten_kota || "",
		provinsi: initialData?.provinsi || "",
		kode_pos: initialData?.kode_pos || "",
		pilihan_jurusan: initialData?.pilihan_jurusan || "",
		asal_sekolah: initialData?.asal_sekolah || "",
		tahun_lulus: initialData?.tahun_lulus || "",
		penerima_kip: !!initialData?.penerima_kip,
		no_kip: initialData?.no_kip || "",
		no_hp: initialData?.no_hp || "",
		bertindik: !!initialData?.bertindik,
		bertato: !!initialData?.bertato,
		yatim_piatu: !!initialData?.yatim_piatu,

		nama_ayah: initialData?.nama_ayah || "",
		no_ayah: initialData?.no_ayah || "",
		pekerjaan_ayah: initialData?.pekerjaan_ayah || "",
		nama_ibu: initialData?.nama_ibu || "",
		no_ibu: initialData?.no_ibu || "",
		pekerjaan_ibu: initialData?.pekerjaan_ibu || "",

		peringkat: initialData?.peringkat || "",
		hafidz: initialData?.hafidz || "",

		jenis_lomba: initialData?.jenis_lomba || "",
		juara_ke: initialData?.juara_ke || "",
		juara_tingkat: initialData?.juara_tingkat || "",

		rekomendasi_mwc: !!initialData?.rekomendasi_mwc,
		saran_dari: initialData?.saran_dari || "",
	});

	const formRef = useRef<HTMLDivElement>(null);
	const cardRef = useRef<HTMLDivElement>(null);

	const getError = (field: string): string | undefined => {
		return clientErrors[field] || errors[field as keyof typeof errors];
	};

	const hasError = (field: string): boolean => {
		return !!getError(field);
	};

	const clearError = (field: string) => {
		if (clientErrors[field]) {
			const newErrors = { ...clientErrors };
			delete newErrors[field];
			setClientErrors(newErrors);
		}
	};

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
		if (isAdmin) {
			return;
		}
		void currentStep;
		gsap.fromTo(
			formRef.current,
			{ opacity: 0, x: 20 },
			{ opacity: 1, x: 0, duration: 0.4, ease: "power2.out" },
		);
		if (cardRef.current) {
			cardRef.current.scrollIntoView({ behavior: "smooth", block: "start" });
		}
	}, [currentStep, isAdmin]);

	const validateStep = (step: number) => {
		const newErrors: Record<string, string> = {};

		if (step === 1) {
			const requiredFields = [
				{ key: "nama_lengkap", label: "Nama Lengkap" },
				{ key: "jenis_kelamin", label: "Jenis Kelamin" },
				{ key: "tempat_lahir", label: "Tempat Lahir" },
				{ key: "tanggal_lahir", label: "Tanggal Lahir" },
				{ key: "nik", label: "NIK" },
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

	const validateAll = () => {
		const newErrors: Record<string, string> = {};

		const requiredFields = [
			{ key: "nama_lengkap", label: "Nama Lengkap" },
			{ key: "jenis_kelamin", label: "Jenis Kelamin" },
			{ key: "tempat_lahir", label: "Tempat Lahir" },
			{ key: "tanggal_lahir", label: "Tanggal Lahir" },
			{ key: "nik", label: "NIK" },
			{ key: "pilihan_jurusan", label: "Pilihan Jurusan" },
			{ key: "asal_sekolah", label: "Asal Sekolah" },
			{ key: "tahun_lulus", label: "Tahun Lulus" },
			{ key: "no_hp", label: "No. HP" },
			{ key: "nama_ayah", label: "Nama Ayah" },
			{ key: "nama_ibu", label: "Nama Ibu" },
		];

		for (const field of requiredFields) {
			// @ts-ignore
			if (!data[field.key]) {
				newErrors[field.key] = `${field.label} wajib diisi`;
			}
		}

		if (data.nik && data.nik.length !== 16) {
			newErrors.nik = "NIK harus terdiri dari 16 digit";
		}

		setClientErrors(newErrors);

		if (Object.keys(newErrors).length > 0) {
			toast.error(Object.values(newErrors)[0]);
			return false;
		}

		return true;
	};

	const nextStep = (e?: React.MouseEvent) => {
		if (e) e.preventDefault();
		if (validateStep(currentStep)) {
			if (currentStep < 4) setCurrentStep(currentStep + 1);
		}
	};

	const prevStep = () => {
		if (currentStep > 1) setCurrentStep(currentStep - 1);
	};

	const fireConfetti = useCallback(() => {
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

		fire(0.25, { spread: 26, startVelocity: 55 });
		fire(0.2, { spread: 60 });
		fire(0.35, { spread: 100, decay: 0.91, scalar: 0.8 });
		fire(0.1, { spread: 120, startVelocity: 25, decay: 0.92, scalar: 1.2 });
		fire(0.1, { spread: 120, startVelocity: 45 });

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

	const handleSubmit = (e: React.FormEvent) => {
		e.preventDefault();

		if (isAdmin && !validateAll()) {
			return;
		}

		if (!isAdmin && !validateStep(4)) {
			return;
		}

		const action = method === "post" ? post : put;

		action(submitUrl, {
			onSuccess: (page) => {
				if (isAdmin) {
					toast.success(
						method === "post"
							? "Pendaftar berhasil ditambahkan"
							: "Data pendaftar berhasil diperbarui",
					);
					if (method === "post") {
						reset();
						setCurrentStep(1);
						clearInertiaErrors();
						setClientErrors({});
					}
					return;
				}

				const flashMessage = (page.props as { flash?: { success?: string } })
					.flash?.success;
				if (flashMessage) {
					const match = flashMessage.match(/([A-Z]{2,}-\d+-\d+-\d+)/);
					if (match) {
						setRegistrationNumber(match[1]);
					}
				}
				setIsSuccess(true);
				fireConfetti();
			},
		});
	};

	const inputClass = "h-11 rounded-lg";

	const schoolField = (
		<FormField
			id="asal_sekolah"
			label="Asal Sekolah"
			required
			error={getError("asal_sekolah")}
		>
			<Popover open={openSchool} onOpenChange={setOpenSchool}>
				<PopoverTrigger asChild>
					<Button
						variant="outline"
						role="combobox"
						aria-expanded={openSchool}
						className={cn(
							"h-11 w-full justify-between rounded-lg text-left font-normal",
							!data.asal_sekolah && "text-muted-foreground",
							hasError("asal_sekolah") &&
								"border-destructive ring-[3px] ring-destructive/20",
						)}
					>
						{data.asal_sekolah ? data.asal_sekolah : "Pilih sekolah..."}
						<ChevronsUpDown className="ml-2 size-4 shrink-0 opacity-50" />
					</Button>
				</PopoverTrigger>
				<PopoverContent className="w-[--radix-popover-trigger-width] p-0">
					<Command>
						<CommandInput
							placeholder="Cari sekolah..."
							value={schoolSearch}
							onValueChange={setSchoolSearch}
						/>
						<CommandList>
							<CommandEmpty>
								<div className="p-2 text-center">
									<p className="text-sm text-muted-foreground">
										Sekolah tidak ditemukan.
									</p>
									<Button
										variant="outline"
										className="mt-2 h-8 w-full text-xs"
										onClick={() => {
											setData("asal_sekolah", schoolSearch.toUpperCase());
											clearError("asal_sekolah");
											setOpenSchool(false);
										}}
									>
										Gunakan "{schoolSearch.toUpperCase()}"
									</Button>
								</div>
							</CommandEmpty>
							<CommandGroup>
								{SCHOOLS.map((school) => (
									<CommandItem
										key={school}
										value={school}
										onSelect={() => {
											setData("asal_sekolah", school);
											clearError("asal_sekolah");
											setOpenSchool(false);
										}}
									>
										<Check
											className={cn(
												"mr-2 h-4 w-4",
												data.asal_sekolah === school
													? "opacity-100"
													: "opacity-0",
											)}
										/>
										{school}
									</CommandItem>
								))}
							</CommandGroup>
						</CommandList>
					</Command>
				</PopoverContent>
			</Popover>
			<p className="text-xs text-muted-foreground">
				Jika sekolah tidak ditemukan, ketik nama sekolah lengkap dan pilih opsi
				'Gunakan ...' untuk menambahkan.
			</p>
		</FormField>
	);

	const identitasFields = (
		<>
			<FormField
				id="nama_lengkap"
				label="Nama Lengkap"
				required
				error={getError("nama_lengkap")}
				className="sm:col-span-2"
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
					className={inputClass}
				/>
			</FormField>

			<FormField
				id="jenis_kelamin"
				label="Jenis Kelamin"
				required
				error={getError("jenis_kelamin")}
			>
				<RadioGroup
					className="mt-2 flex gap-4"
					value={data.jenis_kelamin}
					onValueChange={(value) => {
						setData("jenis_kelamin", value);
						clearError("jenis_kelamin");
					}}
				>
					<div className="flex items-center space-x-2">
						<RadioGroupItem value="l" id="laki-laki" />
						<Label htmlFor="laki-laki" className="cursor-pointer font-normal">
							Laki-laki
						</Label>
					</div>
					<div className="flex items-center space-x-2">
						<RadioGroupItem value="p" id="perempuan" />
						<Label htmlFor="perempuan" className="cursor-pointer font-normal">
							Perempuan
						</Label>
					</div>
				</RadioGroup>
			</FormField>

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
					className={inputClass}
				/>
			</FormField>

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
					className={inputClass}
				/>
			</FormField>

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
					className={inputClass}
					maxLength={16}
				/>
			</FormField>

			<FormField id="nisn" label="NISN" error={getError("nisn")}>
				<Input
					id="nisn"
					placeholder="NISN Peserta"
					value={data.nisn}
					onChange={(e) => setData("nisn", e.target.value)}
					aria-invalid={hasError("nisn")}
					className={inputClass}
				/>
			</FormField>

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
					className={inputClass}
				/>
			</FormField>
		</>
	);

	const alamatFields = (
		<>
			<FormField
				id="alamat_lengkap"
				label="Alamat Jalan"
				error={getError("alamat_lengkap")}
				className="sm:col-span-2"
			>
				<Textarea
					id="alamat_lengkap"
					placeholder="Contoh: Jl. Kutilang No. 12 atau Jl. Diponegoro No. 25"
					value={data.alamat_lengkap}
					onChange={(e) => {
						setData("alamat_lengkap", e.target.value);
						clearError("alamat_lengkap");
					}}
					aria-invalid={hasError("alamat_lengkap")}
					className="min-h-[80px] rounded-lg"
				/>
				<p className="text-xs text-muted-foreground">
					Isi nama jalan/gang saja. Jika tidak diisi, akan otomatis digabungkan
					dari Dukuh, RT/RW, Desa, Kecamatan, Kabupaten, dan Provinsi.
				</p>
			</FormField>

			<FormField id="dukuh" label="Dukuh">
				<Input
					id="dukuh"
					placeholder="Dukuh"
					value={data.dukuh}
					onChange={(e) => setData("dukuh", e.target.value)}
					className={inputClass}
				/>
			</FormField>

			<div className="grid grid-cols-2 gap-4">
				<FormField id="rt" label="RT">
					<Input
						id="rt"
						placeholder="RT"
						value={data.rt}
						onChange={(e) => setData("rt", e.target.value)}
						className={inputClass}
					/>
				</FormField>
				<FormField id="rw" label="RW">
					<Input
						id="rw"
						placeholder="RW"
						value={data.rw}
						onChange={(e) => setData("rw", e.target.value)}
						className={inputClass}
					/>
				</FormField>
			</div>

			<FormField id="desa_kelurahan" label="Desa/Kelurahan">
				<Input
					id="desa_kelurahan"
					placeholder="Desa/Kelurahan"
					value={data.desa_kelurahan}
					onChange={(e) => setData("desa_kelurahan", e.target.value)}
					className={inputClass}
				/>
			</FormField>

			<FormField id="kecamatan" label="Kecamatan">
				<Input
					id="kecamatan"
					placeholder="Kecamatan"
					value={data.kecamatan}
					onChange={(e) => setData("kecamatan", e.target.value)}
					className={inputClass}
				/>
			</FormField>

			<FormField id="kabupaten_kota" label="Kabupaten/Kota">
				<Input
					id="kabupaten_kota"
					placeholder="Kabupaten/Kota"
					value={data.kabupaten_kota}
					onChange={(e) => setData("kabupaten_kota", e.target.value)}
					className={inputClass}
				/>
			</FormField>

			<FormField id="provinsi" label="Provinsi">
				<Input
					id="provinsi"
					placeholder="Provinsi"
					value={data.provinsi}
					onChange={(e) => setData("provinsi", e.target.value)}
					className={inputClass}
				/>
			</FormField>

			<FormField id="kode_pos" label="Kode Pos">
				<Input
					id="kode_pos"
					placeholder="Kode Pos"
					value={data.kode_pos}
					onChange={(e) => setData("kode_pos", e.target.value)}
					className={inputClass}
				/>
			</FormField>
		</>
	);

	const sekolahFields = (
		<>
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
							inputClass,
							hasError("pilihan_jurusan") &&
								"border-destructive ring-[3px] ring-destructive/20",
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

			{schoolField}

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
							inputClass,
							hasError("tahun_lulus") &&
								"border-destructive ring-[3px] ring-destructive/20",
						)}
						aria-invalid={hasError("tahun_lulus")}
					>
						<SelectValue placeholder="Pilih Tahun" />
					</SelectTrigger>
					<SelectContent>
						{Array.from(
							{ length: 8 },
							(_, i) => new Date().getFullYear() - i,
						).map((year) => (
							<SelectItem key={year} value={year.toString()}>
								{year}
							</SelectItem>
						))}
					</SelectContent>
				</Select>
			</FormField>
		</>
	);

	const kipCatatanFields = (
		<>
			<div className="sm:col-span-2">
				<div className="flex items-center space-x-2">
					<Checkbox
						id="penerima_kip"
						checked={data.penerima_kip}
						onCheckedChange={(checked) =>
							setData("penerima_kip", checked as boolean)
						}
					/>
					<Label htmlFor="penerima_kip" className="cursor-pointer font-normal">
						Merupakan peserta Penerima KIP
					</Label>
				</div>
			</div>

			{data.penerima_kip && (
				<FormField id="no_kip" label="No. KIP">
					<Input
						id="no_kip"
						placeholder="Nomor KIP"
						value={data.no_kip}
						onChange={(e) => setData("no_kip", e.target.value)}
						className={inputClass}
					/>
				</FormField>
			)}

			<div className="sm:col-span-2">
				<div className="flex flex-wrap items-center gap-6">
					<div className="flex items-center space-x-2">
						<Checkbox
							id="bertindik"
							checked={data.bertindik}
							onCheckedChange={(checked) =>
								setData("bertindik", checked as boolean)
							}
						/>
						<Label htmlFor="bertindik" className="cursor-pointer font-normal">
							Bertindik
						</Label>
					</div>
					<div className="flex items-center space-x-2">
						<Checkbox
							id="bertato"
							checked={data.bertato}
							onCheckedChange={(checked) =>
								setData("bertato", checked as boolean)
							}
						/>
						<Label htmlFor="bertato" className="cursor-pointer font-normal">
							Bertato
						</Label>
					</div>
				</div>
				<p className="mt-1 text-xs text-muted-foreground">
					Centang jika peserta memiliki tindik (bekas atau aktif di bagian
					tubuh manapun) atau tato (permanen maupun semi-permanen).
				</p>
			</div>
		</>
	);

	const orangTuaFields = (
		<>
			<div className="sm:col-span-2">
				<div className="mb-1 flex items-center gap-2 text-sm font-semibold text-foreground">
					<span className="flex size-7 items-center justify-center rounded-md bg-primary/10 text-xs font-bold text-primary">
						A
					</span>
					Data Ayah
				</div>
			</div>

			<FormField
				id="nama_ayah"
				label="Nama Ayah"
				required
				error={getError("nama_ayah")}
				className="sm:col-span-2"
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
					className={inputClass}
				/>
			</FormField>

			<FormField id="no_ayah" label="No. HP Ayah">
				<Input
					id="no_ayah"
					type="tel"
					placeholder="No. HP Ayah"
					value={data.no_ayah}
					onChange={(e) => setData("no_ayah", e.target.value)}
					className={inputClass}
				/>
			</FormField>

			<FormField id="pekerjaan_ayah" label="Pekerjaan Ayah">
				<Input
					id="pekerjaan_ayah"
					placeholder="Tuliskan pekerjaan ayah"
					value={data.pekerjaan_ayah}
					onChange={(e) => setData("pekerjaan_ayah", e.target.value)}
					className={inputClass}
				/>
			</FormField>

			<div className="sm:col-span-2">
				<div className="mb-1 flex items-center gap-2 text-sm font-semibold text-foreground">
					<span className="flex size-7 items-center justify-center rounded-md bg-primary/10 text-xs font-bold text-primary">
						I
					</span>
					Data Ibu
				</div>
			</div>

			<FormField
				id="nama_ibu"
				label="Nama Ibu"
				required
				error={getError("nama_ibu")}
				className="sm:col-span-2"
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
					className={inputClass}
				/>
			</FormField>

			<FormField id="no_ibu" label="No. HP Ibu">
				<Input
					id="no_ibu"
					type="tel"
					placeholder="No. HP Ibu"
					value={data.no_ibu}
					onChange={(e) => setData("no_ibu", e.target.value)}
					className={inputClass}
				/>
			</FormField>

			<FormField id="pekerjaan_ibu" label="Pekerjaan Ibu">
				<Input
					id="pekerjaan_ibu"
					placeholder="Tuliskan pekerjaan ibu"
					value={data.pekerjaan_ibu}
					onChange={(e) => setData("pekerjaan_ibu", e.target.value)}
					className={inputClass}
				/>
			</FormField>
		</>
	);

	const akademikFields = (
		<>
			<FormField
				id="peringkat"
				label="Peringkat Kelas"
				className="sm:col-span-2"
			>
				<Input
					id="peringkat"
					placeholder="Contoh: Kelas 9 / Semester 1 / Peringkat 1"
					value={data.peringkat}
					onChange={(e) => setData("peringkat", e.target.value)}
					className={inputClass}
				/>
				<p className="text-xs text-muted-foreground">
					Apabila pernah mendapatkan peringkat 1, 2 atau 3
				</p>
			</FormField>

			<FormField
				id="hafidz"
				label="Hafidz / Hafidzoh"
				className="sm:col-span-2"
			>
				<Input
					id="hafidz"
					placeholder="Jumlah juz yang dihafal (minimal 1 juz Al-Qur'an)"
					value={data.hafidz}
					onChange={(e) => setData("hafidz", e.target.value)}
					className={inputClass}
				/>
			</FormField>
		</>
	);

	const nonAkademikFields = (
		<>
			<FormField
				id="jenis_lomba"
				label="Jenis Lomba"
				className="sm:col-span-2"
			>
				<Input
					id="jenis_lomba"
					placeholder="Contoh: Lomba Futsal, Lomba MTQ, dll"
					value={data.jenis_lomba}
					onChange={(e) => setData("jenis_lomba", e.target.value)}
					className={inputClass}
				/>
			</FormField>

			<FormField id="juara_ke" label="Juara ke">
				<Select
					value={data.juara_ke}
					onValueChange={(value) => setData("juara_ke", value)}
				>
					<SelectTrigger className={inputClass}>
						<SelectValue placeholder="Pilih Juara" />
					</SelectTrigger>
					<SelectContent>
						<SelectItem value="1">Juara 1</SelectItem>
						<SelectItem value="2">Juara 2</SelectItem>
						<SelectItem value="3">Juara 3</SelectItem>
					</SelectContent>
				</Select>
			</FormField>

			<FormField id="juara_tingkat" label="Tingkat">
				<Select
					value={data.juara_tingkat}
					onValueChange={(value) => setData("juara_tingkat", value)}
				>
					<SelectTrigger className={inputClass}>
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
		</>
	);

	const rekomendasiFields = (
		<>
			<div className="sm:col-span-2 space-y-3">
				<div className="flex items-center space-x-2 rounded-lg bg-secondary/50 p-4">
					<Checkbox
						id="rekomendasi_mwc"
						checked={data.rekomendasi_mwc}
						onCheckedChange={(checked) =>
							setData("rekomendasi_mwc", checked as boolean)
						}
					/>
					<Label
						htmlFor="rekomendasi_mwc"
						className="cursor-pointer font-normal"
					>
						Merupakan peserta rekomendasi MWC (Majelis Wakil Cabang NU
						Karanganyar)
					</Label>
				</div>

				{isAdmin && (
					<div className="flex items-center space-x-2 rounded-lg bg-secondary/50 p-4">
						<Checkbox
							id="yatim_piatu"
							checked={data.yatim_piatu}
							onCheckedChange={(checked) =>
								setData("yatim_piatu", checked as boolean)
							}
						/>
						<Label
							htmlFor="yatim_piatu"
							className="cursor-pointer font-normal"
						>
							Merupakan peserta Beasiswa Yatim Piatu
						</Label>
					</div>
				)}
				<p className="pl-1 text-xs text-muted-foreground">
					Pilih jenis beasiswa/rekomendasi yang sesuai untuk peserta ini.
				</p>
			</div>

			<FormField
				id="saran_dari"
				label="Saran Dari"
				className="sm:col-span-2"
			>
				<Input
					id="saran_dari"
					placeholder="Contoh: Guru, Teman, Sosial Media, dll"
					value={data.saran_dari}
					onChange={(e) => setData("saran_dari", e.target.value)}
					className={inputClass}
				/>
			</FormField>
		</>
	);

	const persyaratanInfo = (
		<div className="rounded-xl border border-primary/20 bg-primary/5 p-5 sm:col-span-2">
			<h4 className="mb-3 flex items-center gap-2 font-semibold text-foreground">
				<ClipboardList className="size-4 text-primary" />
				Persyaratan Pendaftaran
			</h4>
			<ul className="space-y-2 text-sm text-muted-foreground">
				{[
					"Foto Diri Berwarna Ukuran 3x4 sebanyak 2 lembar",
					"Fotokopi Kartu Keluarga/KK sebanyak 2 lembar",
					"Fotokopi Akte Kelahiran sebanyak 2 lembar",
					"Fotokopi KIP sebanyak 2 lembar (bagi yang punya)",
					"Fotokopi Ijazah sebanyak 2 lembar (jika sudah ada/menyusul)",
					"Fotokopi Raport/Piagam/Sertifikat bagi yang berprestasi",
				].map((item) => (
					<li key={item} className="flex items-start gap-2">
						<CheckCircle2 className="mt-0.5 size-4 shrink-0 text-primary" />
						{item}
					</li>
				))}
			</ul>
		</div>
	);

	const deleteButton =
		isAdmin && showDelete ? (
			<AlertDialog>
				<AlertDialogTrigger asChild>
					<Button variant="destructive" size="sm">
						<Trash2 className="size-4" />
						Hapus Peserta
					</Button>
				</AlertDialogTrigger>
				<AlertDialogContent>
					<AlertDialogHeader>
						<AlertDialogTitle>Hapus Peserta?</AlertDialogTitle>
						<AlertDialogDescription>
							Peserta akan dihapus dari pendaftar SPMB. Tindakan ini tidak
							dapat dibatalkan.
						</AlertDialogDescription>
					</AlertDialogHeader>
					<AlertDialogFooter>
						<AlertDialogCancel>Batal</AlertDialogCancel>
						<AlertDialogAction
							onClick={onDelete}
							className="bg-red-600 hover:bg-red-700"
						>
							Hapus
						</AlertDialogAction>
					</AlertDialogFooter>
				</AlertDialogContent>
			</AlertDialog>
		) : null;

	const submitLabel = processing
		? "Mengirim..."
		: isAdmin && method === "put"
			? "Simpan Perubahan"
			: isAdmin
				? "Simpan Pendaftar"
				: "Kirim Pendaftaran";

	// ── Admin: grid card layout (all sections at once) ──────────────────────
	if (isAdmin) {
		return (
			<div ref={cardRef} className="mx-auto w-full max-w-7xl space-y-6">
				<form onSubmit={handleSubmit} className="space-y-4">
					{/* Header */}
					<Card>
						<CardHeader className="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
							<div className="flex min-w-0 items-start gap-3">
								<div className="flex size-12 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
									<User className="size-6" />
								</div>
								<div className="min-w-0 space-y-1">
									<CardTitle className="text-xl">
										{title || "Tambah Pendaftar Baru"}
									</CardTitle>
									<CardDescription>
										{description ||
											"Silahkan isi formulir pendaftaran peserta didik baru"}
									</CardDescription>
								</div>
							</div>
							{deleteButton}
						</CardHeader>
					</Card>

					{/* Grid sections */}
					<div className="grid grid-cols-1 gap-4 lg:grid-cols-2">
						<SectionCard
							icon={User}
							title="Identitas Diri"
							description="Data pribadi peserta"
						>
							{identitasFields}
						</SectionCard>

						<SectionCard
							icon={MapPin}
							title="Alamat"
							description="Domisili peserta"
						>
							{alamatFields}
						</SectionCard>

						<SectionCard
							icon={School}
							title="Sekolah & Jurusan"
							description="Asal sekolah dan pilihan jurusan"
						>
							{sekolahFields}
						</SectionCard>

						<SectionCard
							icon={IdCard}
							title="KIP & Catatan"
							description="Bantuan dan catatan khusus"
						>
							{kipCatatanFields}
						</SectionCard>

						<SectionCard
							icon={Users}
							title="Identitas Orang Tua"
							description="Data ayah dan ibu"
						>
							{orangTuaFields}
						</SectionCard>

						<SectionCard
							icon={Award}
							title="Beasiswa Akademik"
							description="Prestasi akademik (opsional)"
						>
							{akademikFields}
						</SectionCard>

						<SectionCard
							icon={Trophy}
							title="Beasiswa Non Akademik"
							description="Prestasi lomba (opsional)"
						>
							{nonAkademikFields}
						</SectionCard>

						<SectionCard
							icon={ShieldCheck}
							title="Rekomendasi"
							description="Rekomendasi & sumber informasi"
						>
							{rekomendasiFields}
							{persyaratanInfo}
						</SectionCard>
					</div>

					{/* Actions */}
					<Card>
						<div className="flex flex-col gap-3 px-6 sm:flex-row sm:items-center sm:justify-end">
							<Button
								type="submit"
								disabled={processing}
								className="w-full sm:w-auto"
							>
								<CheckCircle2 className="size-4" />
								{submitLabel}
							</Button>
						</div>
					</Card>
				</form>
			</div>
		);
	}

	// ── Landing: multi-step wizard ──────────────────────────────────────────
	return (
		<div className="mx-auto w-full max-w-4xl px-4">
			{isRejected ? (
				<div className="py-16 text-center">
					<div className="mb-6 inline-flex h-24 w-24 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/30">
						<ShieldAlert className="h-12 w-12 text-amber-600 dark:text-amber-400" />
					</div>
					<h1 className="mb-4 text-3xl font-bold text-foreground md:text-4xl">
						Pendaftaran Tercatat
					</h1>
					<p className="mx-auto mb-6 max-w-xl text-lg text-muted-foreground">
						Mohon maaf, berdasarkan ketentuan sekolah peserta dengan tato tidak
						dapat diterima. Data Anda tetap kami simpan sebagai catatan.
					</p>

					{registrationNumber && (
						<div className="mb-8 inline-block rounded-2xl border border-amber-500/30 bg-amber-500/10 p-6">
							<p className="mb-2 text-sm text-muted-foreground">
								Nomor Pendaftaran
							</p>
							<p className="text-3xl font-bold tracking-wider text-amber-700 dark:text-amber-300">
								{registrationNumber}
							</p>
						</div>
					)}

					<Card className="mx-auto max-w-lg overflow-hidden rounded-3xl border-0 shadow-xl">
						<CardContent className="p-8">
							<div className="space-y-4">
								<div className="flex items-start gap-3 text-left">
									<Info className="mt-0.5 h-5 w-5 shrink-0 text-amber-600 dark:text-amber-400" />
									<p className="text-muted-foreground">
										Pendaftaran Anda telah tercatat di sistem kami, namun
										dinyatakan ditolak.
									</p>
								</div>
								<div className="flex items-start gap-3 text-left">
									<Info className="mt-0.5 h-5 w-5 shrink-0 text-amber-600 dark:text-amber-400" />
									<p className="text-muted-foreground">
										Untuk informasi lebih lanjut, silakan hubungi panitia SPMB
										SMK Diponegoro Karanganyar.
									</p>
								</div>
							</div>

							<Button
								className="mt-8 h-12 w-full rounded-xl text-base"
								variant="outline"
								onClick={() => router.visit("/")}
							>
								<Home className="mr-2 h-4 w-4" />
								Kembali ke Beranda
							</Button>
						</CardContent>
					</Card>
				</div>
			) : isSuccess ? (
				<div className="py-16 text-center">
					<div className="mb-6 inline-flex h-24 w-24 animate-bounce items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
						<PartyPopper className="h-12 w-12 text-green-600 dark:text-green-400" />
					</div>
					<h1 className="mb-4 text-4xl font-bold text-foreground md:text-5xl">
						Selamat! 🎉
					</h1>
					<p className="mb-6 text-xl text-muted-foreground">
						Pendaftaran Anda berhasil disubmit
					</p>

					{registrationNumber && (
						<div className="mb-8 inline-block rounded-2xl border border-primary/20 bg-primary/10 p-6">
							<p className="mb-2 text-sm text-muted-foreground">
								Nomor Pendaftaran Anda
							</p>
							<p className="text-3xl font-bold tracking-wider text-primary">
								{registrationNumber}
							</p>
						</div>
					)}

					<Card className="mx-auto max-w-lg overflow-hidden rounded-3xl border-0 shadow-xl">
						<CardContent className="p-8">
							<div className="space-y-4">
								<div className="flex items-start gap-3 text-left">
									<CheckCircle2 className="mt-0.5 h-5 w-5 shrink-0 text-green-600 dark:text-green-400" />
									<p className="text-muted-foreground">
										Simpan nomor pendaftaran Anda untuk keperluan daftar ulang
									</p>
								</div>
								<div className="flex items-start gap-3 text-left">
									<CheckCircle2 className="mt-0.5 h-5 w-5 shrink-0 text-green-600 dark:text-green-400" />
									<p className="text-muted-foreground">
										Siapkan berkas-berkas yang diperlukan untuk proses
										selanjutnya
									</p>
								</div>
								<div className="flex items-start gap-3 text-left">
									<CheckCircle2 className="mt-0.5 h-5 w-5 shrink-0 text-green-600 dark:text-green-400" />
									<p className="text-muted-foreground">
										Tim SPMB akan menghubungi Anda melalui No. HP yang terdaftar
									</p>
								</div>
							</div>

							<Button
								className="mt-8 h-12 w-full rounded-xl text-base"
								onClick={() => router.visit("/")}
							>
								<Home className="mr-2 h-4 w-4" />
								Kembali ke Beranda
							</Button>
						</CardContent>
					</Card>
				</div>
			) : (
				<>
					<div className="mb-10 text-center">
						<div className="mb-4 inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-primary/10">
							<GraduationCap className="h-10 w-10 text-primary" />
						</div>
						<h1 className="mb-2 text-3xl font-bold text-foreground md:text-4xl">
							Formulir Pendaftaran
						</h1>
						<p className="text-muted-foreground">
							SPMB, Sistem Penerimaan Murid Baru SMK Diponegoro Karanganyar
							Tahun Ajaran 2026/2027
						</p>
					</div>

					{/* Progress Steps */}
					<div className="mb-8">
						<div className="relative flex items-center justify-between">
							<div className="absolute top-6 right-0 left-0 mx-12 h-1 rounded-full bg-border">
								<div
									className="h-full rounded-full bg-primary transition-all duration-500"
									style={{ width: `${((currentStep - 1) / 3) * 100}%` }}
								/>
							</div>

							{steps.map((step) => (
								<div
									key={step.id}
									className="relative z-10 flex flex-col items-center gap-2"
								>
									<div
										className={`flex h-12 w-12 items-center justify-center rounded-2xl transition-all duration-300 ${
											step.id === currentStep
												? "scale-110 bg-primary text-white shadow-lg shadow-primary/30"
												: step.id < currentStep
													? "bg-primary/20 text-primary"
													: "border-2 border-border bg-white text-muted-foreground"
										}`}
									>
										{step.id < currentStep ? (
											<CheckCircle2 className="h-6 w-6" />
										) : (
											<step.icon className="h-5 w-5" />
										)}
									</div>
									<span
										className={`hidden text-xs font-medium sm:block ${
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
						className="w-full overflow-hidden rounded-3xl border-0 shadow-2xl shadow-primary/5"
					>
						<CardHeader className="border-b bg-linear-gradient-to-r from-primary/5 to-accent/50">
							<div className="flex items-center justify-between">
								<div>
									<CardTitle className="flex items-center gap-3 text-xl">
										{(() => {
											const StepIcon = steps[currentStep - 1].icon;
											return <StepIcon className="h-6 w-6 text-primary" />;
										})()}
										{steps[currentStep - 1].title}
									</CardTitle>
									<CardDescription>
										Langkah {currentStep} dari 4 - Isi formulir sesuai data
										dirimu
									</CardDescription>
								</div>
							</div>
						</CardHeader>

						<CardContent className="p-6 md:p-8">
							<form onSubmit={handleSubmit}>
								<div ref={formRef}>
									{currentStep === 1 && (
										<div className="space-y-6">
											<div className="grid gap-6 md:grid-cols-2">
												{identitasFields}
												{alamatFields}
												{sekolahFields}
												{kipCatatanFields}
											</div>
										</div>
									)}

									{currentStep === 2 && (
										<div className="grid gap-6 md:grid-cols-2">
											{orangTuaFields}
										</div>
									)}

									{currentStep === 3 && (
										<div className="space-y-8">
											<p className="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-muted-foreground dark:border-amber-800 dark:bg-amber-950/30">
												Jenis beasiswa peserta. Diisi jika peserta memiliki
												beasiswa atau prestasi.
											</p>
											<div className="grid gap-6 md:grid-cols-2">
												<div className="md:col-span-2">
													<h3 className="mb-4 flex items-center gap-2 text-lg font-semibold">
														<span className="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-sm font-bold text-blue-600 dark:bg-blue-950/50 dark:text-blue-400">
															A
														</span>
														Akademik
													</h3>
												</div>
												{akademikFields}
												<div className="md:col-span-2">
													<h3 className="mb-4 flex items-center gap-2 text-lg font-semibold">
														<span className="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-sm font-bold text-amber-600 dark:bg-amber-950/50 dark:text-amber-400">
															N
														</span>
														Non Akademik
													</h3>
												</div>
												{nonAkademikFields}
											</div>
										</div>
									)}

									{currentStep === 4 && (
										<div className="grid gap-6 md:grid-cols-2">
											{rekomendasiFields}
											{persyaratanInfo}
										</div>
									)}
								</div>

								<div className="mt-8 flex justify-between border-t pt-6">
									<Button
										type="button"
										variant="outline"
										onClick={prevStep}
										disabled={currentStep === 1}
										className="rounded-xl bg-transparent px-6"
									>
										<ChevronLeft className="mr-2 h-4 w-4" />
										Sebelumnya
									</Button>

									{currentStep < 4 ? (
										<Button
											type="button"
											onClick={nextStep}
											className="rounded-xl px-6"
										>
											Selanjutnya
											<ChevronRight className="ml-2 h-4 w-4" />
										</Button>
									) : (
										<Button
											type="submit"
											disabled={processing}
											className="rounded-xl bg-primary px-8 hover:bg-primary/90"
										>
											<CheckCircle2 className="mr-2 h-4 w-4" />
											{submitLabel}
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

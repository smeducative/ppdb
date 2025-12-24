import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Label } from "@/components/ui/label";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { Head, Link, router } from "@inertiajs/react";
import {
	ArrowRight,
	Film,
	Leaf,
	Settings,
	UserCheck,
	Users,
	UserX,
	Wifi,
} from "lucide-react";
import {
	Bar,
	BarChart,
	CartesianGrid,
	Cell,
	Legend,
	Pie,
	PieChart,
	ResponsiveContainer,
	Tooltip,
	XAxis,
	YAxis,
} from "recharts";

interface DashboardProps {
	count: Record<string, number>;
	du: Record<string, number>;
	penerimaan: { diterima: number; ditolak: number };
	compareSx: { l: number[]; p: number[] };
	compareDx: { l: number[]; p: number[] };
	yearDiff: Record<number, { bulan: string; jumlah_pendaftar: number }[]>;
	yearDiffDaftarUlang: Record<
		number,
		{ bulan: string; jumlah_daftar_ulang: number }[]
	>;
	pendaftarPerSekolah: { asal_sekolah: string; as_count: number }[];
	pendaftarPerSekolahCount: { asal_sekolah: string; as_count: number }[];
	daftarUlangPerSekolah: { asal_sekolah: string; as_count: number }[];
	daftarUlangPerSekolahCount: { asal_sekolah: string; as_count: number }[];
	genderOverTime: Record<
		number,
		{ bulan: string; laki: number; perempuan: number }
	>;
	tahun: number;
	lastYear: string;
	oldestYear: number;
}

const COLORS = ["#f56954", "#00c0ef", "#00a65a", "#f39c12", "#3c8dbc"];
const JURUSAN_LABELS = ["TKJ", "AT", "BDP", "TSM", "TKR"];

export default function Dashboard({
	count,
	du,
	penerimaan,
	compareSx,
	compareDx,
	yearDiff,
	yearDiffDaftarUlang,
	pendaftarPerSekolah,
	pendaftarPerSekolahCount,
	daftarUlangPerSekolah,
	daftarUlangPerSekolahCount,
	genderOverTime,
	tahun,
	lastYear,
	oldestYear,
}: DashboardProps) {
	// Generate year options from current year down to oldest year
	const currentYear = new Date().getFullYear();
	const yearOptions: number[] = [];
	for (let i = currentYear; i >= oldestYear; i--) {
		yearOptions.push(i);
	}

	// Handle year change
	const handleYearChange = (value: string) => {
		router.visit(route("dashboard", { tahun: value }), {
			preserveState: true,
			preserveScroll: true,
		});
	};

	// Helper to format data for charts
	const pieData = [
		{ name: "TKJ", value: count.tkj },
		{ name: "AT", value: count.atph },
		{ name: "BDP", value: count.bdp },
		{ name: "TSM", value: count.tsm },
		{ name: "TKR", value: count.tkr },
	];

	const pieDuData = [
		{ name: "TKJ", value: du.tkj },
		{ name: "AT", value: du.atph },
		{ name: "BDP", value: du.bdp },
		{ name: "TSM", value: du.tsm },
		{ name: "TKR", value: du.tkr },
	];

	const genderData = JURUSAN_LABELS.map((label, index) => ({
		name: label,
		Laki: compareSx.l[index],
		Perempuan: compareSx.p[index],
	}));

	const genderDuData = JURUSAN_LABELS.map((label, index) => ({
		name: label,
		Laki: compareDx.l[index],
		Perempuan: compareDx.p[index],
	}));

	// Transform yearDiff for Recharts
	const months = [
		"Jan",
		"Feb",
		"Mar",
		"Apr",
		"Mei",
		"Jun",
		"Jul",
		"Agu",
		"Sep",
		"Okt",
		"Nov",
		"Des",
	];

	const yearDiffData = months.map((month) => {
		const currentYearData = yearDiff[tahun]?.find((d) => d.bulan === month);
		const lastYearData = yearDiff[Number(lastYear)]?.find(
			(d) => d.bulan === month,
		);

		return {
			name: month,
			[`${tahun}`]: currentYearData?.jumlah_pendaftar || 0,
			[`${lastYear}`]: lastYearData?.jumlah_pendaftar || 0,
		};
	});

	const yearDiffDuData = months.map((month) => {
		const currentYearData = yearDiffDaftarUlang[tahun]?.find(
			(d) => d.bulan === month,
		);
		const lastYearData = yearDiffDaftarUlang[Number(lastYear)]?.find(
			(d) => d.bulan === month,
		);

		return {
			name: month,
			[`${tahun}`]: currentYearData?.jumlah_daftar_ulang || 0,
			[`${lastYear}`]: lastYearData?.jumlah_daftar_ulang || 0,
		};
	});

	// Transform genderOverTime for Recharts (stacked bar)
	const genderOverTimeData = Object.values(genderOverTime || {}).map(
		(item) => ({
			name: item.bulan,
			Laki: item.laki,
			Perempuan: item.perempuan,
		}),
	);

	// Transform top schools data for bar chart
	const topSchoolsData = (pendaftarPerSekolah || []).map((item) => ({
		name: item.asal_sekolah,
		jumlah: item.as_count,
	}));

	const topSchoolsDuData = (daftarUlangPerSekolah || []).map((item) => ({
		name: item.asal_sekolah,
		jumlah: item.as_count,
	}));

	return (
		<>
			<Head title="Dashboard" />

			<div className="space-y-6">
				{/* Header with Year Filter */}
				<div className="flex flex-wrap justify-between items-center gap-4">
					<h1 className="font-bold text-2xl">Dashboard</h1>
					<div className="flex items-center gap-2">
						<Label htmlFor="year-filter">Data Tahun:</Label>
						<Select
							value={tahun.toString()}
							onValueChange={handleYearChange}
						>
							<SelectTrigger className="w-[120px]" id="year-filter">
								<SelectValue placeholder="Pilih Tahun" />
							</SelectTrigger>
							<SelectContent>
								{yearOptions.map((year) => (
									<SelectItem key={year} value={year.toString()}>
										{year}
									</SelectItem>
								))}
							</SelectContent>
						</Select>
					</div>
				</div>

				{/* Total Stats Cards */}
				<h3 className="font-medium text-lg">Jumlah Total</h3>
				<div className="gap-4 grid md:grid-cols-2 lg:grid-cols-4">
					<StatsCard
						title="Total Pendaftar"
						value={count.all}
						icon={Users}
						className="bg-amber-500/10 border-amber-500/20"
					/>
					<StatsCard
						title="Total Daftar Ulang"
						value={du.all}
						icon={UserCheck}
						className="bg-amber-500/10 border-amber-500/20"
					/>
					<StatsCard
						title="Total Peserta Diterima"
						value={penerimaan.diterima}
						icon={UserCheck}
						className="bg-amber-500/10 border-amber-500/20"
					/>
					<StatsCard
						title="Total Peserta Ditolak"
						value={penerimaan.ditolak}
						icon={UserX}
						className="bg-amber-500/10 border-amber-500/20"
					/>
				</div>

				{/* Info Pendaftar Section */}
				<h3 className="font-medium text-lg">Info Pendaftar</h3>
				<div className="gap-4 grid md:grid-cols-2 lg:grid-cols-5">
					<StatsCardWithLink
						title="AT"
						value={count.atph}
						icon={Leaf}
						className="bg-green-500/10 border-green-500/20"
						href={route("ppdb.list.pendaftar.jurusan", { jurusan: 3 })}
					/>
					<StatsCardWithLink
						title="TSM"
						value={count.tsm}
						icon={Settings}
						className="bg-blue-500/10 border-blue-500/20"
						href={route("ppdb.list.pendaftar.jurusan", { jurusan: 6 })}
					/>
					<StatsCardWithLink
						title="TKR"
						value={count.tkr}
						icon={Settings}
						className="bg-blue-500/10 border-blue-500/20"
						href={route("ppdb.list.pendaftar.jurusan", { jurusan: 7 })}
					/>
					<StatsCardWithLink
						title="TKJ"
						value={count.tkj}
						icon={Wifi}
						className="bg-red-500/10 border-red-500/20"
						href={route("ppdb.list.pendaftar.jurusan", { jurusan: 1 })}
					/>
					<StatsCardWithLink
						title="BDP"
						value={count.bdp}
						icon={Film}
						className="bg-orange-500/10 border-orange-500/20"
						href={route("ppdb.list.pendaftar.jurusan", { jurusan: 4 })}
					/>
				</div>

				{/* Info Daftar Ulang Section */}
				<h3 className="font-medium text-lg">Info Daftar Ulang</h3>
				<div className="gap-4 grid md:grid-cols-2 lg:grid-cols-5">
					<StatsCardWithLink
						title="AT"
						value={du.atph}
						icon={Leaf}
						className="bg-green-500/10 border-green-500/20"
						href={route("ppdb.daftar.ulang.list", { jurusan: 3 })}
					/>
					<StatsCardWithLink
						title="TSM"
						value={du.tsm}
						icon={Settings}
						className="bg-blue-500/10 border-blue-500/20"
						href={route("ppdb.daftar.ulang.list", { jurusan: 6 })}
					/>
					<StatsCardWithLink
						title="TKR"
						value={du.tkr}
						icon={Settings}
						className="bg-blue-500/10 border-blue-500/20"
						href={route("ppdb.daftar.ulang.list", { jurusan: 7 })}
					/>
					<StatsCardWithLink
						title="TKJ"
						value={du.tkj}
						icon={Wifi}
						className="bg-red-500/10 border-red-500/20"
						href={route("ppdb.daftar.ulang.list", { jurusan: 1 })}
					/>
					<StatsCardWithLink
						title="BDP"
						value={du.bdp}
						icon={Film}
						className="bg-orange-500/10 border-orange-500/20"
						href={route("ppdb.daftar.ulang.list", { jurusan: 4 })}
					/>
				</div>

				{/* Charts Section */}
				<h3 className="font-medium text-lg">Graphic Chart</h3>

				<div className="gap-4 grid md:grid-cols-2">
					{/* Gender comparison - Pendaftar */}
					<Card>
						<CardHeader>
							<CardTitle>Perbandingan Jenis Kelamin Pendaftar</CardTitle>
						</CardHeader>
						<CardContent>
							<ResponsiveContainer width="100%" height={300}>
								<BarChart data={genderData}>
									<CartesianGrid strokeDasharray="3 3" />
									<XAxis dataKey="name" />
									<YAxis />
									<Tooltip />
									<Legend />
									<Bar dataKey="Perempuan" fill="#d2d6de" />
									<Bar dataKey="Laki" fill="#3b8bba" />
								</BarChart>
							</ResponsiveContainer>
						</CardContent>
					</Card>

					{/* Gender comparison - Daftar Ulang */}
					<Card>
						<CardHeader>
							<CardTitle>Perbandingan Jenis Kelamin Daftar Ulang</CardTitle>
						</CardHeader>
						<CardContent>
							<ResponsiveContainer width="100%" height={300}>
								<BarChart data={genderDuData}>
									<CartesianGrid strokeDasharray="3 3" />
									<XAxis dataKey="name" />
									<YAxis />
									<Tooltip />
									<Legend />
									<Bar dataKey="Perempuan" fill="#d2d6de" />
									<Bar dataKey="Laki" fill="#3b8bba" />
								</BarChart>
							</ResponsiveContainer>
						</CardContent>
					</Card>

					{/* Pie Chart - Pendaftar per Jurusan */}
					<Card>
						<CardHeader>
							<CardTitle>Perbandingan Pendaftar Tiap Jurusan</CardTitle>
						</CardHeader>
						<CardContent>
							<ResponsiveContainer width="100%" height={300}>
								<PieChart>
									<Pie
										data={pieData}
										cx="50%"
										cy="50%"
										labelLine={false}
										label={({ name, percent }) =>
											`${name} ${(percent * 100).toFixed(0)}%`
										}
										outerRadius={80}
										fill="#8884d8"
										dataKey="value"
									>
										{pieData.map((entry, index) => (
											<Cell
												key={`cell-${entry.name}`}
												fill={COLORS[index % COLORS.length]}
											/>
										))}
									</Pie>
									<Tooltip />
								</PieChart>
							</ResponsiveContainer>
						</CardContent>
					</Card>

					{/* Pie Chart - Daftar Ulang per Jurusan */}
					<Card>
						<CardHeader>
							<CardTitle>Perbandingan Daftar Ulang Tiap Jurusan</CardTitle>
						</CardHeader>
						<CardContent>
							<ResponsiveContainer width="100%" height={300}>
								<PieChart>
									<Pie
										data={pieDuData}
										cx="50%"
										cy="50%"
										labelLine={false}
										label={({ name, percent }) =>
											`${name} ${(percent * 100).toFixed(0)}%`
										}
										outerRadius={80}
										fill="#8884d8"
										dataKey="value"
									>
										{pieDuData.map((entry, index) => (
											<Cell
												key={`cell-du-${entry.name}`}
												fill={COLORS[index % COLORS.length]}
											/>
										))}
									</Pie>
									<Tooltip />
								</PieChart>
							</ResponsiveContainer>
						</CardContent>
					</Card>
				</div>

				{/* Year Comparison - Pendaftar */}
				<Card>
					<CardHeader>
						<CardTitle>
							Perbandingan Pendaftar Perbulan dengan Tahun Sebelumnya
						</CardTitle>
					</CardHeader>
					<CardContent>
						<ResponsiveContainer width="100%" height={300}>
							<BarChart data={yearDiffData}>
								<CartesianGrid strokeDasharray="3 3" />
								<XAxis dataKey="name" />
								<YAxis />
								<Tooltip />
								<Legend />
								<Bar
									dataKey={tahun.toString()}
									fill="rgba(54, 162, 235, 0.7)"
									name={`Tahun ${tahun}`}
								/>
								<Bar
									dataKey={lastYear}
									fill="rgba(255, 99, 132, 0.7)"
									name={`Tahun ${lastYear}`}
								/>
							</BarChart>
						</ResponsiveContainer>
					</CardContent>
				</Card>

				{/* Year Comparison - Daftar Ulang */}
				<Card>
					<CardHeader>
						<CardTitle>
							Perbandingan Daftar Ulang Perbulan dengan Tahun Sebelumnya
						</CardTitle>
					</CardHeader>
					<CardContent>
						<ResponsiveContainer width="100%" height={300}>
							<BarChart data={yearDiffDuData}>
								<CartesianGrid strokeDasharray="3 3" />
								<XAxis dataKey="name" />
								<YAxis />
								<Tooltip />
								<Legend />
								<Bar
									dataKey={tahun.toString()}
									fill="rgba(54, 162, 235, 0.7)"
									name={`Tahun ${tahun}`}
								/>
								<Bar
									dataKey={lastYear}
									fill="rgba(255, 99, 132, 0.7)"
									name={`Tahun ${lastYear}`}
								/>
							</BarChart>
						</ResponsiveContainer>
					</CardContent>
				</Card>

				{/* Top 10 Schools - Pendaftar Bar Chart */}
				<Card>
					<CardHeader>
						<CardTitle>Top 10 Sekolah Pendaftar</CardTitle>
					</CardHeader>
					<CardContent>
						<ResponsiveContainer width="100%" height={300}>
							<BarChart data={topSchoolsData} layout="vertical">
								<CartesianGrid strokeDasharray="3 3" />
								<XAxis type="number" />
								<YAxis
									dataKey="name"
									type="category"
									width={150}
									tick={{ fontSize: 12 }}
								/>
								<Tooltip />
								<Bar dataKey="jumlah" fill="rgba(255, 159, 64, 0.9)" />
							</BarChart>
						</ResponsiveContainer>
					</CardContent>
				</Card>

				{/* Gender Distribution Over Time - Stacked Bar Chart */}
				<Card>
					<CardHeader>
						<CardTitle>Distribusi Jenis Kelamin Pendaftar per Bulan</CardTitle>
					</CardHeader>
					<CardContent>
						<ResponsiveContainer width="100%" height={300}>
							<BarChart data={genderOverTimeData}>
								<CartesianGrid strokeDasharray="3 3" />
								<XAxis dataKey="name" />
								<YAxis />
								<Tooltip />
								<Legend />
								<Bar
									dataKey="Laki"
									stackId="gender"
									fill="rgba(54, 162, 235, 0.9)"
								/>
								<Bar
									dataKey="Perempuan"
									stackId="gender"
									fill="rgba(255, 99, 132, 0.9)"
								/>
							</BarChart>
						</ResponsiveContainer>
					</CardContent>
				</Card>

				{/* Pendaftar Per Sekolah Table */}
				<Card>
					<CardHeader className="flex flex-row justify-between items-center">
						<CardTitle>Jumlah Pendaftar Per Sekolah</CardTitle>
						<Button asChild variant="outline" size="sm">
							<a href={route("export.rekap-sekolah", { tahun })}>
								Export .xlsx
							</a>
						</Button>
					</CardHeader>
					<CardContent>
						{pendaftarPerSekolahCount && pendaftarPerSekolahCount.length > 0 ? (
							<div className="border rounded-md overflow-x-auto">
								<table className="w-full text-sm text-left">
									<thead className="bg-muted text-muted-foreground text-xs uppercase">
										<tr>
											<th className="px-6 py-3">Nama Sekolah</th>
											<th className="px-6 py-3 text-right">Jumlah</th>
										</tr>
									</thead>
									<tbody className="divide-y divide-border">
										{pendaftarPerSekolahCount.map((sekolah) => (
											<tr
												key={sekolah.asal_sekolah}
												className="bg-card hover:bg-muted/50 transition-colors"
											>
												<td className="px-6 py-4 font-medium text-foreground">
													{sekolah.asal_sekolah}
												</td>
												<td className="px-6 py-4 font-semibold text-right">
													{sekolah.as_count}
												</td>
											</tr>
										))}
									</tbody>
								</table>
							</div>
						) : (
							<p className="text-muted-foreground">Belum ada peserta</p>
						)}
					</CardContent>
				</Card>

				{/* Top 10 Schools - Daftar Ulang Bar Chart */}
				<Card>
					<CardHeader>
						<CardTitle>Top 10 Sekolah Daftar Ulang</CardTitle>
					</CardHeader>
					<CardContent>
						<ResponsiveContainer width="100%" height={300}>
							<BarChart data={topSchoolsDuData} layout="vertical">
								<CartesianGrid strokeDasharray="3 3" />
								<XAxis type="number" />
								<YAxis
									dataKey="name"
									type="category"
									width={150}
									tick={{ fontSize: 12 }}
								/>
								<Tooltip />
								<Bar dataKey="jumlah" fill="rgba(255, 159, 64, 0.9)" />
							</BarChart>
						</ResponsiveContainer>
					</CardContent>
				</Card>

				{/* Daftar Ulang Per Sekolah Table */}
				<Card>
					<CardHeader>
						<CardTitle>Jumlah Daftar Ulang Per Sekolah</CardTitle>
					</CardHeader>
					<CardContent>
						{daftarUlangPerSekolahCount &&
						daftarUlangPerSekolahCount.length > 0 ? (
							<div className="border rounded-md overflow-x-auto">
								<table className="w-full text-sm text-left">
									<thead className="bg-muted text-muted-foreground text-xs uppercase">
										<tr>
											<th className="px-6 py-3">Nama Sekolah</th>
											<th className="px-6 py-3 text-right">Jumlah</th>
										</tr>
									</thead>
									<tbody className="divide-y divide-border">
										{daftarUlangPerSekolahCount.map((sekolah) => (
											<tr
												key={sekolah.asal_sekolah}
												className="bg-card hover:bg-muted/50 transition-colors"
											>
												<td className="px-6 py-4 font-medium text-foreground">
													{sekolah.asal_sekolah}
												</td>
												<td className="px-6 py-4 font-semibold text-right">
													{sekolah.as_count}
												</td>
											</tr>
										))}
									</tbody>
								</table>
							</div>
						) : (
							<p className="text-muted-foreground">Belum ada peserta</p>
						)}
					</CardContent>
				</Card>
			</div>
		</>
	);
}

function StatsCard({
	title,
	value,
	icon: Icon,
	className,
}: {
	title: string;
	value: number;
	icon: React.ComponentType<{ className?: string }>;
	className?: string;
}) {
	return (
		<Card className={className}>
			<CardHeader className="flex flex-row justify-between items-center space-y-0 pb-2">
				<CardTitle className="font-medium text-sm">{title}</CardTitle>
				<Icon className="w-4 h-4 text-muted-foreground" />
			</CardHeader>
			<CardContent>
				<div className="font-bold text-2xl">{value}</div>
			</CardContent>
		</Card>
	);
}

function StatsCardWithLink({
	title,
	value,
	icon: Icon,
	className,
	href,
}: {
	title: string;
	value: number;
	icon: React.ComponentType<{ className?: string }>;
	className?: string;
	href: string;
}) {
	return (
		<Card className={className}>
			<CardHeader className="flex flex-row justify-between items-center space-y-0 pb-2">
				<CardTitle className="font-medium text-sm">{title}</CardTitle>
				<Icon className="w-4 h-4 text-muted-foreground" />
			</CardHeader>
			<CardContent>
				<div className="font-bold text-2xl">{value}</div>
			</CardContent>
			<Link
				href={href}
				className="flex justify-center items-center gap-1 bg-black/10 dark:bg-white/10 px-3 py-2 rounded-b-lg w-full text-sm hover:underline"
			>
				More info <ArrowRight className="w-3 h-3" />
			</Link>
		</Card>
	);
}

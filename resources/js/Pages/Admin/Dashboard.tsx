import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Head } from "@inertiajs/react";
import {
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
	dailyTrends: { tanggal: string; jumlah: number }[];
	pendaftarPerSekolahCount: { asal_sekolah: string; as_count: number }[];
	daftarUlangPerSekolahCount: { asal_sekolah: string; as_count: number }[];
	tahun: number;
	lastYear: string;
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
	dailyTrends,
	pendaftarPerSekolahCount,
	daftarUlangPerSekolahCount,
	tahun,
	lastYear,
}: DashboardProps) {
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
	// Assuming months are standard Jan-Des.
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

	return (
		<>
			<Head title="Dashboard" />

			<div className="space-y-6">
				{/* Stats Cards */}
				<div className="gap-4 grid md:grid-cols-2 lg:grid-cols-4">
					<StatsCard
						title="Total Pendaftar"
						value={count.all}
						icon={Users}
						className="bg-primary/10 border-primary/20"
					/>
					<StatsCard
						title="Total Daftar Ulang"
						value={du.all}
						icon={UserCheck}
						className="bg-primary/10 border-primary/20"
					/>
					<StatsCard
						title="Diterima"
						value={penerimaan.diterima}
						icon={UserCheck}
						className="bg-green-500/10 border-green-500/20"
					/>
					<StatsCard
						title="Ditolak"
						value={penerimaan.ditolak}
						icon={UserX}
						className="bg-destructive/10 border-destructive/20"
					/>
				</div>

				<h3 className="font-medium text-lg">Info Pendaftar</h3>
				<div className="gap-4 grid md:grid-cols-2 lg:grid-cols-5">
					<StatsCard
						title="AT"
						value={count.atph}
						icon={Leaf}
						className="bg-green-500/10 border-green-500/20"
					/>
					<StatsCard
						title="TSM"
						value={count.tsm}
						icon={Settings}
						className="bg-blue-500/10 border-blue-500/20"
					/>
					<StatsCard
						title="TKR"
						value={count.tkr}
						icon={Settings}
						className="bg-blue-500/10 border-blue-500/20"
					/>
					<StatsCard
						title="TKJ"
						value={count.tkj}
						icon={Wifi}
						className="bg-red-500/10 border-red-500/20"
					/>
					<StatsCard
						title="BDP"
						value={count.bdp}
						icon={Film}
						className="bg-orange-500/10 border-orange-500/20"
					/>
				</div>

				<div className="gap-4 grid md:grid-cols-2">
					<Card>
						<CardHeader>
							<CardTitle>Perbandingan Pendaftar Jenis Kelamin</CardTitle>
						</CardHeader>
						<CardContent>
							<ResponsiveContainer width="100%" height={300}>
								<BarChart data={genderData}>
									<CartesianGrid strokeDasharray="3 3" />
									<XAxis dataKey="name" />
									<YAxis />
									<Tooltip />
									<Legend />
									<Bar dataKey="Laki" fill="#3b8bba" />
									<Bar dataKey="Perempuan" fill="#d2d6de" />
								</BarChart>
							</ResponsiveContainer>
						</CardContent>
					</Card>

					<Card>
						<CardHeader>
							<CardTitle>Perbandingan Daftar Ulang Jenis Kelamin</CardTitle>
						</CardHeader>
						<CardContent>
							<ResponsiveContainer width="100%" height={300}>
								<BarChart data={genderDuData}>
									<CartesianGrid strokeDasharray="3 3" />
									<XAxis dataKey="name" />
									<YAxis />
									<Tooltip />
									<Legend />
									<Bar dataKey="Laki" fill="#3b8bba" />
									<Bar dataKey="Perempuan" fill="#d2d6de" />
								</BarChart>
							</ResponsiveContainer>
						</CardContent>
					</Card>

					<Card>
						<CardHeader>
							<CardTitle>Pendaftar per Jurusan</CardTitle>
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
												key={`cell-${index}`}
												fill={COLORS[index % COLORS.length]}
											/>
										))}
									</Pie>
									<Tooltip />
								</PieChart>
							</ResponsiveContainer>
						</CardContent>
					</Card>

					<Card>
						<CardHeader>
							<CardTitle>Daftar Ulang per Jurusan</CardTitle>
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
												key={`cell-${index}`}
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

				<Card>
					<CardHeader>
						<CardTitle>
							Perbandingan Pendaftar Bulanan ({lastYear} vs {tahun})
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
									dataKey={lastYear}
									fill="rgba(255, 99, 132, 0.5)"
									name={`Tahun ${lastYear}`}
								/>
								<Bar
									dataKey={tahun}
									fill="rgba(54, 162, 235, 0.5)"
									name={`Tahun ${tahun}`}
								/>
							</BarChart>
						</ResponsiveContainer>
					</CardContent>
				</Card>

				<div className="gap-4 grid md:grid-cols-2">
					<Card>
						<CardHeader>
							<CardTitle>Jumlah Pendaftar Per Sekolah (Top 10)</CardTitle>
						</CardHeader>
						<CardContent>
							<div className="overflow-x-auto rounded-md border">
								<table className="w-full text-sm text-left">
									<thead className="bg-muted text-muted-foreground text-xs uppercase">
										<tr>
											<th className="px-6 py-3">Nama Sekolah</th>
											<th className="px-6 py-3 text-right">Jumlah</th>
										</tr>
									</thead>
									<tbody className="divide-y divide-border">
										{pendaftarPerSekolahCount
											.slice(0, 10)
											.map((sekolah, idx) => (
												<tr
													key={idx}
													className="bg-card hover:bg-muted/50 transition-colors"
												>
													<td className="px-6 py-4 font-medium text-foreground">
														{sekolah.asal_sekolah}
													</td>
													<td className="px-6 py-4 text-right font-semibold">
														{sekolah.as_count}
													</td>
												</tr>
											))}
									</tbody>
								</table>
							</div>
						</CardContent>
					</Card>

					<Card>
						<CardHeader>
							<CardTitle>Jumlah Daftar Ulang Per Sekolah (Top 10)</CardTitle>
						</CardHeader>
						<CardContent>
							<div className="overflow-x-auto rounded-md border">
								<table className="w-full text-sm text-left">
									<thead className="bg-muted text-muted-foreground text-xs uppercase">
										<tr>
											<th className="px-6 py-3">Nama Sekolah</th>
											<th className="px-6 py-3 text-right">Jumlah</th>
										</tr>
									</thead>
									<tbody className="divide-y divide-border">
										{daftarUlangPerSekolahCount
											.slice(0, 10)
											.map((sekolah, idx) => (
												<tr
													key={idx}
													className="bg-card hover:bg-muted/50 transition-colors"
												>
													<td className="px-6 py-4 font-medium text-foreground">
														{sekolah.asal_sekolah}
													</td>
													<td className="px-6 py-4 text-right font-semibold">
														{sekolah.as_count}
													</td>
												</tr>
											))}
									</tbody>
								</table>
							</div>
						</CardContent>
					</Card>
				</div>
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
	icon: any;
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

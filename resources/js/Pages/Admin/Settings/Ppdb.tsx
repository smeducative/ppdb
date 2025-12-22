import { AlertMessages } from "@/components/alert-messages";
import { Button } from "@/components/ui/button";
import {
	Card,
	CardContent,
	CardDescription,
	CardFooter,
	CardHeader,
	CardTitle,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Head, useForm, usePage } from "@inertiajs/react";

interface PpdbSetting {
	id: number;
	body: {
		batas_akhir_ppdb: string;
		no_surat: string;
		hasil_seleksi: string;
	};
}

interface Props {
	setting: PpdbSetting;
}

export default function Ppdb({ setting }: Props) {
	const { data, setData, put, processing, errors } = useForm({
		batas_akhir_ppdb: setting?.body?.batas_akhir_ppdb || "",
		no_surat: setting?.body?.no_surat || "",
		hasil_seleksi: setting?.body?.hasil_seleksi || "",
	});

	const submit = (e: React.FormEvent) => {
		e.preventDefault();
		put(route("ppdb.set.batas.akhir"));
	};

	const { flash } = usePage<any>().props;

	// Helper to format date for display (visual confirmation for user)
	const formatDate = (dateString: string) => {
		if (!dateString) return "-";
		try {
			// Check if format is dd-mm-yyyy (from inputmask)
			// The inputmask format is dd-mm-yyyy, but we might save it as such or parse it.
			// Assuming it's saved as string dd-mm-yyyy for now based on the previous controller logic.
			// Wait, the previous view used Carbon parse.
			// If the input is dd-mm-yyyy, Carbon might struggle if not configured for standard format.
			// Let's assume input is standard text for now.
			return dateString;
		} catch (e) {
			return dateString;
		}
	};

	return (
		<>
			<Head title="Pengaturan PPDB" />

			<div className="max-w-2xl mx-auto space-y-6">
				<AlertMessages flash={flash} />

				<Card>
					<CardHeader>
						<CardTitle>Pengaturan PPDB</CardTitle>
						<CardDescription>
							Atur batas akhir pendaftaran, nomor surat, dan tanggal pengumuman.
						</CardDescription>
					</CardHeader>
					<form onSubmit={submit}>
						<CardContent className="space-y-4">
							<div className="grid grid-cols-2 gap-4 mb-4 p-4 bg-muted rounded">
								<div>
									<strong className="block text-sm font-medium">
										No. Surat
									</strong>
									<span className="text-sm">{data.no_surat || "-"}</span>
								</div>
								<div>
									<strong className="block text-sm font-medium">
										Batas Akhir PPDB
									</strong>
									<span className="text-sm">
										{data.batas_akhir_ppdb || "-"}
									</span>
								</div>
								<div>
									<strong className="block text-sm font-medium">
										Pengumuman Seleksi
									</strong>
									<span className="text-sm">{data.hasil_seleksi || "-"}</span>
								</div>
							</div>

							<div className="space-y-2">
								<Label htmlFor="no_surat">No. Surat</Label>
								<Input
									id="no_surat"
									value={data.no_surat}
									onChange={(e) => setData("no_surat", e.target.value)}
									placeholder="No. Surat"
									required
								/>
								{errors.no_surat && (
									<div className="text-destructive text-sm">
										{errors.no_surat}
									</div>
								)}
							</div>

							<div className="space-y-2">
								<Label htmlFor="batas_akhir_ppdb">
									Batas Akhir PPDB (dd-mm-yyyy)
								</Label>
								<Input
									id="batas_akhir_ppdb"
									value={data.batas_akhir_ppdb}
									onChange={(e) => setData("batas_akhir_ppdb", e.target.value)}
									placeholder="dd-mm-yyyy"
									required
								/>
								{errors.batas_akhir_ppdb && (
									<div className="text-red-500 text-sm">
										{errors.batas_akhir_ppdb}
									</div>
								)}
							</div>

							<div className="space-y-2">
								<Label htmlFor="hasil_seleksi">
									Pengumuman Hasil Seleksi (dd-mm-yyyy)
								</Label>
								<Input
									id="hasil_seleksi"
									value={data.hasil_seleksi}
									onChange={(e) => setData("hasil_seleksi", e.target.value)}
									placeholder="dd-mm-yyyy"
									required
								/>
								{errors.hasil_seleksi && (
									<div className="text-red-500 text-sm">
										{errors.hasil_seleksi}
									</div>
								)}
							</div>
						</CardContent>
						<CardFooter>
							<Button type="submit" disabled={processing}>
								{processing ? "Menyimpan..." : "Atur"}
							</Button>
						</CardFooter>
					</form>
				</Card>
			</div>
		</>
	);
}

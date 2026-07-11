import { Button, buttonVariants } from "@/components/ui/button";
import {
	Dialog,
	DialogContent,
	DialogDescription,
	DialogFooter,
	DialogHeader,
	DialogTitle,
} from "@/components/ui/dialog";
import { Label } from "@/components/ui/label";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { type VariantProps } from "class-variance-authority";
import { useState } from "react";

type ExportStatus = "semua" | "diterima" | "sudah_du" | "belum_du";

type ButtonVariant = VariantProps<typeof buttonVariants>["variant"];
type ButtonSize = VariantProps<typeof buttonVariants>["size"];

interface ExportStatusDialogProps {
	routeName: string;
	params?: Record<string, string | number>;
	defaultStatus?: ExportStatus;
	label?: string;
	variant?: ButtonVariant;
	size?: ButtonSize;
	className?: string;
}

const STATUS_OPTIONS: { value: ExportStatus; label: string }[] = [
	{ value: "semua", label: "Semua Peserta" },
	{ value: "diterima", label: "Peserta Diterima" },
	{ value: "sudah_du", label: "Peserta Sudah Daftar Ulang (Kwitansi)" },
	{ value: "belum_du", label: "Peserta Belum Daftar Ulang" },
];

export function ExportStatusDialog({
	routeName,
	params = {},
	defaultStatus = "semua",
	label = "Export Excel",
	variant,
	size,
	className,
}: ExportStatusDialogProps) {
	const [open, setOpen] = useState(false);
	const [status, setStatus] = useState<ExportStatus>(defaultStatus);

	return (
		<>
			<Button
				variant={variant}
				size={size}
				className={className}
				onClick={() => setOpen(true)}
			>
				{label}
			</Button>
			<Dialog open={open} onOpenChange={setOpen}>
				<DialogContent className="sm:max-w-[480px]">
					<DialogHeader>
						<DialogTitle>Export Data Peserta</DialogTitle>
						<DialogDescription>
							Pilih kategori peserta yang akan diekspor.
						</DialogDescription>
					</DialogHeader>
					<div className="space-y-2">
						<Label htmlFor="export-status">Kategori Peserta</Label>
						<Select
							value={status}
							onValueChange={(value) => setStatus(value as ExportStatus)}
						>
							<SelectTrigger id="export-status">
								<SelectValue placeholder="Pilih kategori" />
							</SelectTrigger>
							<SelectContent>
								{STATUS_OPTIONS.map((option) => (
									<SelectItem key={option.value} value={option.value}>
										{option.label}
									</SelectItem>
								))}
							</SelectContent>
						</Select>
					</div>
					<DialogFooter>
						<Button variant="outline" onClick={() => setOpen(false)}>
							Batal
						</Button>
						<Button asChild>
							<a
								href={route(routeName, { ...params, status })}
								onClick={() => setOpen(false)}
							>
								Download
							</a>
						</Button>
					</DialogFooter>
				</DialogContent>
			</Dialog>
		</>
	);
}

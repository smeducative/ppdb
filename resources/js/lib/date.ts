import { format } from "date-fns";
import { id } from "date-fns/locale";

/**
 * Format tanggal dengan waktu dalam format Indonesia
 * Contoh output: "22-Agustus-2025 22:00"
 * @param date - Tanggal dalam format string atau Date object
 */
export function formatDateTime(date: string | Date | null | undefined): string {
	if (!date) return "-";
	const d = new Date(date);
	if (isNaN(d.getTime())) return "-";
	return format(d, "dd-MMMM-yyyy HH:mm", { locale: id });
}

/**
 * Format tanggal saja dalam format Indonesia
 * Contoh output: "22-Agustus-2025"
 * @param date - Tanggal dalam format string atau Date object
 */
export function formatDate(date: string | Date | null | undefined): string {
	if (!date) return "-";
	const d = new Date(date);
	if (isNaN(d.getTime())) return "-";
	return format(d, "dd-MMMM-yyyy", { locale: id });
}

/**
 * Format tanggal pendek dalam format Indonesia
 * Contoh output: "22-08-2025"
 * @param date - Tanggal dalam format string atau Date object
 */
export function formatDateShort(
	date: string | Date | null | undefined,
): string {
	if (!date) return "-";
	const d = new Date(date);
	if (isNaN(d.getTime())) return "-";
	return format(d, "dd-MM-yyyy", { locale: id });
}
/**
 * Format tanggal lengkap dengan hari dalam format Indonesia
 * Contoh output: "Jumat, 22-Agustus-2025"
 * @param date - Tanggal dalam format string atau Date object
 */
export function formatDateFull(date: string | Date | null | undefined): string {
	if (!date) return "-";
	const d = new Date(date);
	if (isNaN(d.getTime())) return "-";
	return format(d, "EEEE, dd-MMMM-yyyy", { locale: id });
}

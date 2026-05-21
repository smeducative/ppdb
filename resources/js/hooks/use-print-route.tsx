import { usePage } from "@inertiajs/react";
import {
	type ReactNode,
	useCallback,
	useEffect,
	useId,
	useRef,
	useState,
} from "react";
import { toast } from "sonner";

const PRINT_RESET_TIMEOUT_MS = 30_000;

export interface UsePrintRouteResult {
	printFromRoute: (url: string, documentId?: string) => void;
	printingDocumentId: string | null;
	isPrinting: boolean;
	PrintFrame: () => ReactNode;
}

export function usePrintRoute(): UsePrintRouteResult {
	const { csrf_token } = usePage().props as { csrf_token?: string };
	const frameName = `ppdb-print-frame-${useId().replace(/:/g, "")}`;
	const [printingDocumentId, setPrintingDocumentId] = useState<string | null>(
		null,
	);
	const iframeRef = useRef<HTMLIFrameElement | null>(null);
	const formRef = useRef<HTMLFormElement | null>(null);
	const tokenRef = useRef<HTMLInputElement | null>(null);
	const resetTimerRef = useRef<number | null>(null);

	useEffect(() => {
		return () => {
			if (resetTimerRef.current !== null) {
				window.clearTimeout(resetTimerRef.current);
			}
		};
	}, []);

	const printFromRoute = useCallback(
		(url: string, documentId: string = url): void => {
			if (!csrf_token) {
				toast.error(
					"Token keamanan cetak tidak ditemukan. Muat ulang halaman lalu coba lagi.",
				);
				return;
			}

			const form = formRef.current;
			const token = tokenRef.current;
			const iframe = iframeRef.current;

			if (!form || !token || !iframe) {
				toast.error("Komponen cetak belum siap.");
				return;
			}

			setPrintingDocumentId(documentId);

			token.value = csrf_token;
			form.action = url;
			form.submit();

			if (resetTimerRef.current !== null) {
				window.clearTimeout(resetTimerRef.current);
			}
			resetTimerRef.current = window.setTimeout(() => {
				setPrintingDocumentId(null);
			}, PRINT_RESET_TIMEOUT_MS);
		},
		[csrf_token],
	);

	const handleIframeLoad = useCallback((): void => {
		const iframe = iframeRef.current;
		if (!iframe) {
			return;
		}

		try {
			const doc = iframe.contentDocument;
			if (!doc || doc.location.href === "about:blank") {
				return;
			}
		} catch {
			setPrintingDocumentId(null);
			return;
		}

		if (resetTimerRef.current !== null) {
			window.clearTimeout(resetTimerRef.current);
			resetTimerRef.current = null;
		}

		setPrintingDocumentId(null);
	}, []);

	const PrintFrame = useCallback((): ReactNode => {
		return (
			<>
				<form
					ref={formRef}
					method="POST"
					target={frameName}
					className="hidden"
					aria-hidden="true"
				>
					<input ref={tokenRef} type="hidden" name="_token" value="" />
				</form>
				<iframe
					ref={iframeRef}
					name={frameName}
					title="Print preview"
					onLoad={handleIframeLoad}
					style={{
						position: "fixed",
						right: 0,
						bottom: 0,
						width: 0,
						height: 0,
						border: 0,
						visibility: "hidden",
					}}
				/>
			</>
		);
	}, [frameName, handleIframeLoad]);

	return {
		printFromRoute,
		printingDocumentId,
		isPrinting: printingDocumentId !== null,
		PrintFrame,
	};
}

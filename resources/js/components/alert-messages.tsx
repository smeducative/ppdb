import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import { AlertTriangle, CheckCircle2, Info, XCircle } from "lucide-react";

interface AlertMessagesProps {
	flash: {
		success?: string;
		error?: string;
		warning?: string;
		info?: string;
		message?: string;
	};
}

/**
 * Reusable component to display flash messages using Shadcn Alert component.
 * Supports different types of messages (success, error, warning, info).
 */
export function AlertMessages({ flash }: AlertMessagesProps) {
	if (!flash) return null;

	const messages = [
		{
			type: "success",
			content: flash.success,
			icon: CheckCircle2,
			variant: "default" as const,
			className:
				"bg-green-500/15 text-green-600 border-green-500/20 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20",
		},
		{
			type: "error",
			content: flash.error,
			icon: XCircle,
			variant: "destructive" as const,
			className: "",
		},
		{
			type: "warning",
			content: flash.warning,
			icon: AlertTriangle,
			variant: "default" as const,
			className:
				"bg-yellow-500/15 text-yellow-600 border-yellow-500/20 dark:bg-yellow-500/10 dark:text-yellow-400 dark:border-yellow-500/20",
		},
		{
			type: "info",
			content: flash.info || flash.message,
			icon: Info,
			variant: "default" as const,
			className:
				"bg-blue-500/15 text-blue-600 border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20",
		},
	];

	return (
		<div className="space-y-4 mb-6">
			{messages.map(
				(msg) =>
					msg.content && (
						<Alert
							key={msg.type}
							variant={msg.variant}
							className={msg.className}
						>
							<msg.icon className="h-4 w-4" />
							<AlertTitle className="capitalize">{msg.type}</AlertTitle>
							<AlertDescription>{msg.content}</AlertDescription>
						</Alert>
					),
			)}
		</div>
	);
}

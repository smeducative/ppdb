import { LoginForm } from "@/components/login-form";
import { Head } from "@inertiajs/react";

export default function Login() {
	return (
		<div className="flex min-h-svh w-full items-center justify-center p-6 md:p-10">
			<Head title="Login" />
			<div className="w-full max-w-sm">
				<LoginForm />
			</div>
		</div>
	);
}

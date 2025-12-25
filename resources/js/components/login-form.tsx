import { Button } from "@/components/ui/button";
import {
	Card,
	CardContent,
	CardDescription,
	CardHeader,
	CardTitle,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { cn } from "@/lib/utils";
import { useForm } from "@inertiajs/react";
import { Eye, EyeOff } from "lucide-react";
import { useState } from "react";

export function LoginForm({
	className,
	...props
}: React.ComponentPropsWithoutRef<"div">) {
	const { data, setData, post, processing, errors } = useForm({
		niy: "",
		password: "",
		remember: false,
	});
	const [showPassword, setShowPassword] = useState(false);

	const submit = (e: React.FormEvent) => {
		e.preventDefault();
		post(route("login"));
	};

	return (
		<div className={cn("flex flex-col gap-6", className)} {...props}>
			<Card>
				<CardHeader>
					<CardTitle className="text-2xl">Login</CardTitle>
					<CardDescription>
						Masukkan NIY dan password Anda untuk masuk ke dashboard
					</CardDescription>
				</CardHeader>
				<CardContent>
					<form onSubmit={submit}>
						<div className="flex flex-col gap-6">
							<div className="gap-2 grid">
								<Label htmlFor="niy">NIY</Label>
								<Input
									id="niy"
									type="text"
									placeholder="Nomor Induk Yayasan"
									value={data.niy}
									onChange={(e) => setData("niy", e.target.value)}
									autoFocus
									required
								/>
								{errors.niy && (
									<p className="font-medium text-red-500 text-sm">
										{errors.niy}
									</p>
								)}
							</div>
							<div className="gap-2 grid">
								<Label htmlFor="password">Password</Label>
								<div className="relative">
									<Input
										id="password"
										type={showPassword ? "text" : "password"}
										placeholder="Password"
										value={data.password}
										onChange={(e) => setData("password", e.target.value)}
										required
										className="pr-10"
									/>
									<button
										type="button"
										onClick={() => setShowPassword(!showPassword)}
										className="top-1/2 right-3 absolute text-gray-500 hover:text-gray-700 dark:hover:text-gray-200 dark:text-gray-400 -translate-y-1/2"
										aria-label={
											showPassword ? "Hide password" : "Show password"
										}
									>
										{showPassword ? (
											<EyeOff className="w-4 h-4" />
										) : (
											<Eye className="w-4 h-4" />
										)}
									</button>
								</div>
								{errors.password && (
									<p className="font-medium text-red-500 text-sm">
										{errors.password}
									</p>
								)}
							</div>
							<Button type="submit" className="w-full" disabled={processing}>
								{processing ? "Logging in..." : "Login"}
							</Button>
						</div>
					</form>
				</CardContent>
			</Card>
		</div>
	);
}

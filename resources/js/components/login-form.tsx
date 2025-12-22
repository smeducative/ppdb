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

export function LoginForm({
	className,
	...props
}: React.ComponentPropsWithoutRef<"div">) {
	const { data, setData, post, processing, errors } = useForm({
		niy: "",
		password: "",
		remember: false,
	});

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
							<div className="grid gap-2">
								<Label htmlFor="niy">NIY</Label>
								<Input
									id="niy"
									type="text"
									placeholder="Nomor Induk Yayasan"
									value={data.niy}
									onChange={(e) => setData("niy", e.target.value)}
									required
								/>
								{errors.niy && (
									<p className="text-sm text-red-500 font-medium">
										{errors.niy}
									</p>
								)}
							</div>
							<div className="grid gap-2">
								<div className="flex items-center">
									<Label htmlFor="password">Password</Label>
								</div>
								<Input
									id="password"
									type="password"
									value={data.password}
									onChange={(e) => setData("password", e.target.value)}
									required
								/>
								{errors.password && (
									<p className="text-sm text-red-500 font-medium">
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

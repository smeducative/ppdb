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
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import type { User } from "@/types";
import { Head, useForm, usePage } from "@inertiajs/react";

interface Props {
	user: User;
}

export default function Profile({ user }: Props) {
	const { data, setData, put, processing, errors, reset } = useForm({
		name: user.name,
		password: "",
		password_confirmation: "",
	});

	const submit = (e: React.FormEvent) => {
		e.preventDefault();
		put(route("setting.profile"), {
			onSuccess: () => reset("password", "password_confirmation"),
		});
	};

	const { flash } = usePage<any>().props;

	return (
		<AuthenticatedLayout header="Pengaturan Akun">
			<Head title="Pengaturan Akun" />

			<div className="max-w-2xl mx-auto space-y-6">
				{flash.success && (
					<div
						className="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
						role="alert"
					>
						<strong className="font-bold">Success! </strong>
						<span className="block sm:inline">{flash.success}</span>
					</div>
				)}

				<Card>
					<CardHeader>
						<CardTitle>Profile Information</CardTitle>
						<CardDescription>
							Update your account's profile information and password.
						</CardDescription>
					</CardHeader>
					<form onSubmit={submit}>
						<CardContent className="space-y-4">
							<div className="space-y-2">
								<Label htmlFor="name">Name</Label>
								<Input
									id="name"
									value={data.name}
									onChange={(e) => setData("name", e.target.value)}
									required
								/>
								{errors.name && (
									<div className="text-red-500 text-sm">{errors.name}</div>
								)}
							</div>

							<div className="space-y-2">
								<Label htmlFor="password">New Password</Label>
								<Input
									id="password"
									type="password"
									value={data.password}
									onChange={(e) => setData("password", e.target.value)}
									required
								/>
								{errors.password && (
									<div className="text-red-500 text-sm">{errors.password}</div>
								)}
							</div>

							<div className="space-y-2">
								<Label htmlFor="password_confirmation">Confirm Password</Label>
								<Input
									id="password_confirmation"
									type="password"
									value={data.password_confirmation}
									onChange={(e) =>
										setData("password_confirmation", e.target.value)
									}
									required
								/>
							</div>
						</CardContent>
						<CardFooter>
							<Button type="submit" disabled={processing}>
								{processing ? "Saving..." : "Save"}
							</Button>
						</CardFooter>
					</form>
				</Card>
			</div>
		</AuthenticatedLayout>
	);
}

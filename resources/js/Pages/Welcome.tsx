import { Button } from "@/components/ui/button";
import { Head } from "@inertiajs/react";

export default function Welcome() {
	return (
		<>
			<Head title="Welcome" />
			<div className="min-h-screen bg-background flex flex-col items-center justify-center p-6 text-center">
				<div className="max-w-2xl w-full space-y-8">
					<div className="space-y-2">
						<h1 className="text-5xl font-extrabold tracking-tight lg:text-6xl text-primary">
							Inertia.js + Shadcn UI
						</h1>
						<p className="text-xl text-muted-foreground">
							Successfully migrated to the latest Inertia.js with React and
							initialized Shadcn UI using Bun.
						</p>
					</div>

					<div className="flex flex-col sm:flex-row gap-4 justify-center items-center mt-10">
						<Button
							variant="default"
							size="lg"
							onClick={() => alert("Shadcn Button Working!")}
						>
							Get Started
						</Button>
						<Button variant="outline" size="lg" asChild>
							<a href="https://ui.shadcn.com" target="_blank" rel="noreferrer">
								Documentation
							</a>
						</Button>
					</div>

					<div className="grid grid-cols-1 md:grid-cols-2 gap-4 mt-12 text-left">
						<div className="p-6 rounded-xl border bg-card text-card-foreground shadow">
							<h3 className="text-lg font-semibold mb-2">Inertia.js</h3>
							<p className="text-sm text-muted-foreground">
								High-performance single-page apps without the complexity of a
								client-side API.
							</p>
						</div>
						<div className="p-6 rounded-xl border bg-card text-card-foreground shadow">
							<h3 className="text-lg font-semibold mb-2">Shadcn UI</h3>
							<p className="text-sm text-muted-foreground">
								Beautifully designed components built with Radix UI and Tailwind
								CSS.
							</p>
						</div>
					</div>

					<footer className="mt-16 text-sm text-muted-foreground">
						Initialized with Bun & Shadcn MCP
					</footer>
				</div>
			</div>
		</>
	);
}

type RouteParams = Record<string, string | number | boolean | undefined>;

type RouteResolver = (params?: RouteParams) => string;

type RouteConfig = Record<string, string | RouteResolver>;

const routes: RouteConfig = {
	dashboard: "/dashboard",
	login: "/login",
	"ppdb.register": "/register",
	"ppdb.register.submit": "/register",
	"setting.profile": "/dashboard/setting/profile",
	"ppdb.set.batas.akhir": "/dashboard/setting/ppdb",
	"ppdb.list.pendaftar": "/dashboard/ppdb/list-pendaftar",
	"ppdb.list.pendaftar.jurusan": ({ jurusan } = {}) =>
		`/dashboard/ppdb/list-pendaftar/${jurusan ?? ""}`,
	"ppdb.tambah.pendaftar": "/dashboard/ppdb/tambah-pendaftar",
	"ppdb.show.peserta": ({ id } = {}) => `/dashboard/ppdb/show/${id ?? ""}`,
	"ppdb.edit.peserta": ({ id } = {}) => `/dashboard/ppdb/edit/${id ?? ""}`,
	"ppdb.delete.peserta": ({ id } = {}) => `/dashboard/ppdb/delete/${id ?? ""}`,
	"ppdb.terima.peserta": ({ uuid } = {}) =>
		`/dashboard/ppdb/daftar-ulang/${uuid ?? ""}`,
	"ppdb.daftar.ulang.list": ({ jurusan } = {}) =>
		jurusan
			? `/dashboard/ppdb/list/terdaftar-ulang/${jurusan}`
			: "/dashboard/ppdb/list/terdaftar-ulang",
	"ppdb.list.daftar.ulang": ({ jurusan } = {}) =>
		jurusan
			? `/dashboard/ppdb/list/terdaftar-ulang/${jurusan}`
			: "/dashboard/ppdb/list/terdaftar-ulang",
	"ppdb.belum.daftar.ulang.list": ({ jurusan } = {}) =>
		jurusan
			? `/dashboard/ppdb/list/belum-daftar-ulang/${jurusan}`
			: "/dashboard/ppdb/list/belum-daftar-ulang",
	"ppdb.list.belum.daftar.ulang": ({ jurusan } = {}) =>
		jurusan
			? `/dashboard/ppdb/list/belum-daftar-ulang/${jurusan}`
			: "/dashboard/ppdb/list/belum-daftar-ulang",
	"ppdb.kwitansi.show": "/dashboard/kwitansi/show",
	"ppdb.kwitansi.show.jurusan": ({ jurusan } = {}) =>
		`/dashboard/kwitansi/show/${jurusan ?? ""}`,
	"ppdb.kwitansi.tambah": ({ uuid } = {}) =>
		`/dashboard/kwitansi/tambah/${uuid ?? ""}`,
	"ppdb.kwitansi.hapus": ({ id } = {}) =>
		`/dashboard/kwitansi/hapus/${id ?? ""}`,
	"ppdb.kwitansi.index": "/dashboard/kwitansi/show",
	"ppdb.cetak.kwitansi": ({ uuid } = {}) =>
		`/dashboard/kwitansi/cetak/kwitansi/${uuid ?? ""}`,
	"ppdb.cetak.kwitansi.single": ({ uuid, id } = {}) =>
		`/dashboard/kwitansi/cetak/kwitansi/${uuid ?? ""}/${id ?? ""}`,
	"ppdb.rekap.kwitansi": "/dashboard/kwitansi/rekap",
	"ppdb.kwitansi.rekap": "/dashboard/kwitansi/rekap",
	"ppdb.rekap.kwitansi-dana": "/dashboard/kwitansi/rekap/cetak-dana",
	"ppdb.rekap.kwitansi-riwayat": "/dashboard/kwitansi/rekap/cetak-riwayat",
	"ppdb.seragam.show.jurusan": ({ jurusan } = {}) =>
		jurusan
			? `/dashboard/ukuran-seragam/show/${jurusan}`
			: "/dashboard/ukuran-seragam/show",
	"ppdb.ukuran.seragam": ({ jurusan } = {}) =>
		jurusan
			? `/dashboard/ukuran-seragam/show/${jurusan}`
			: "/dashboard/ukuran-seragam/show",
	"ppdb.ubah.seragam": "/dashboard/ukuran-seragam/ubah/seragam",
	"ppdb.surat.show.jurusan": ({ jurusan } = {}) =>
		jurusan ? `/dashboard/surat/show/${jurusan}` : "/dashboard/surat/show",
	"ppdb.cetak.surat.semua": ({ jurusan } = {}) =>
		`/dashboard/surat/cetak/surat/${jurusan ?? ""}`,
	"ppdb.cetak.surat": ({ uuid } = {}) =>
		`/dashboard/surat/cetak/surat/${uuid ?? ""}/single`,
	"ppdb.formulir.show.jurusan": ({ jurusan } = {}) =>
		jurusan
			? `/dashboard/formulir/show/${jurusan}`
			: "/dashboard/formulir/show",
	"ppdb.cetak.formulir.semua": ({ jurusan } = {}) =>
		`/dashboard/formulir/cetak/formulir/${jurusan ?? ""}`,
	"ppdb.cetak.formulir": ({ uuid } = {}) =>
		`/dashboard/formulir/cetak/formulir/${uuid ?? ""}/single`,
	"ppdb.kartu.show.jurusan": ({ jurusan } = {}) =>
		jurusan
			? `/dashboard/kartu-pendaftaran/show/${jurusan}`
			: "/dashboard/kartu-pendaftaran/show",
	"ppdb.cetak.kartu.semua": ({ jurusan } = {}) =>
		`/dashboard/kartu-pendaftaran/cetak/kartu/${jurusan ?? ""}`,
	"ppdb.cetak.kartu": ({ uuid } = {}) =>
		`/dashboard/kartu-pendaftaran/cetak/kartu/${uuid ?? ""}/single`,
	"export.peserta.ppdb": "/dashboard/export/peserta-ppdb",
	"export.seragam": "/dashboard/export/ukuran-seragam",
	"export.rekap-sekolah": "/dashboard/export/rekap-sekolah",
	"export.belum.daftar.ulang": "/dashboard/export/belum-daftar-ulang",
	"ppdb.beasiswa.mwc": "/dashboard/beasiswa/rekomendasi-mwc",
	"ppdb.beasiswa.mwc.export": "/dashboard/beasiswa/rekomendasi-mwc",
	"ppdb.beasiswa.akademik": "/dashboard/beasiswa/akademik",
	"ppdb.beasiswa.akademik.export": "/dashboard/beasiswa/akademik",
	"ppdb.beasiswa.non-akademik": "/dashboard/beasiswa/non-akademik",
	"ppdb.beasiswa.non-akademik.export": "/dashboard/beasiswa/non-akademik",
	"ppdb.beasiswa.kip": "/dashboard/beasiswa/kip",
	"ppdb.beasiswa.kip.export": "/dashboard/beasiswa/kip",
	"ppdb.beasiswa.tahfidz": "/dashboard/beasiswa/tahfidz",
	"ppdb.beasiswa.tahfidz.export": "/dashboard/beasiswa/tahfidz",
};

const interpolate = (path: string, params: RouteParams = {}) => {
	return path.replace(/\{(\w+)\??\}/g, (_, key) => {
		const value = params[key];
		return value === undefined || value === null
			? ""
			: encodeURIComponent(String(value));
	});
};

export function route(
	name?: string,
	params?: RouteParams,
	absolute = false,
	_config?: unknown,
): string {
	if (!name) {
		return "/";
	}

	const resolver = routes[name];
	const path = typeof resolver === "function" ? resolver(params) : resolver;

	if (!path) {
		if (process.env.NODE_ENV !== "production") {
			console.warn(`Unknown route: ${name}`);
		}
		return name;
	}

	const interpolated = interpolate(path, params);
	if (!absolute) {
		return interpolated;
	}

	const base = typeof window !== "undefined" ? window.location.origin : "";
	try {
		return new URL(interpolated, base || undefined).toString();
	} catch (error) {
		return interpolated;
	}
}

if (typeof window !== "undefined") {
	// @ts-expect-error: assigning to global for backward compatibility
	window.route = route;
}

export default route;

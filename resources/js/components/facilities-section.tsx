import { useEffect, useRef } from "react"
import {
  CheckCircle,
  Monitor,
  BookOpen,
  Users,
  Building,
  GraduationCap,
  Award,
  Warehouse,
  Leaf,
  Utensils,
  Dumbbell,
  Wrench,
} from "lucide-react"
import gsap from "gsap"
import { ScrollTrigger } from "gsap/ScrollTrigger"

gsap.registerPlugin(ScrollTrigger)

const advantages = [
  {
    icon: GraduationCap,
    title: "Pengajar Berkualitas",
    description: "Guru berpengalaman dan tersertifikasi di bidangnya",
  },
  {
    icon: Award,
    title: "Kurikulum Industri",
    description: "Kurikulum yang disesuaikan dengan kebutuhan dunia kerja",
  },
  {
    icon: Users,
    title: "Kelas Kecil",
    description: "Rasio guru dan siswa yang ideal untuk pembelajaran efektif",
  },
  {
    icon: Building,
    title: "Magang Industri",
    description: "Program PKL di perusahaan mitra terpercaya",
  },
]

const facilities = [
  { icon: Building, name: "Ruang Teori", description: "Ruang kelas nyaman & kondusif" },
  { icon: Building, name: "Masjid", description: "Tempat ibadah yang representatif" },
  { icon: Monitor, name: "Lab TJKT ber-AC", description: "Lab komputer dengan pendingin" },
  { icon: Wrench, name: "Lab Otomotif", description: "Praktik kendaraan lengkap" },
  { icon: Leaf, name: "Lab Agribisnis Tanaman", description: "Praktik budidaya tanaman" },
  { icon: Monitor, name: "Lab SIMDIG ber-AC", description: "Simulasi digital modern" },
  { icon: Warehouse, name: "Green House", description: "Rumah kaca untuk pertanian" },
  { icon: Utensils, name: "Kantin Sekolah", description: "Makanan sehat & terjangkau" },
  { icon: BookOpen, name: "Perpustakaan", description: "Koleksi buku lengkap" },
  { icon: Dumbbell, name: "Lapangan Olahraga", description: "Voli, Futsal, Basket" },
]

export function FacilitiesSection() {
  const sectionRef = useRef<HTMLElement>(null)
  const titleRef = useRef<HTMLDivElement>(null)
  const leftRef = useRef<HTMLDivElement>(null)
  const rightRef = useRef<HTMLDivElement>(null)
  const imageRef = useRef<HTMLDivElement>(null)

  useEffect(() => {
    const ctx = gsap.context(() => {
      gsap.fromTo(
        titleRef.current,
        { opacity: 0, y: 50 },
        {
          opacity: 1,
          y: 0,
          duration: 0.8,
          scrollTrigger: { trigger: titleRef.current, start: "top 80%" },
        },
      )

      gsap.fromTo(
        leftRef.current,
        { opacity: 0, x: -60 },
        {
          opacity: 1,
          x: 0,
          duration: 0.8,
          scrollTrigger: { trigger: leftRef.current, start: "top 80%" },
        },
      )

      gsap.fromTo(
        rightRef.current,
        { opacity: 0, x: 60 },
        {
          opacity: 1,
          x: 0,
          duration: 0.8,
          scrollTrigger: { trigger: rightRef.current, start: "top 80%" },
        },
      )

      gsap.fromTo(
        imageRef.current,
        { opacity: 0, y: 60, scale: 0.95 },
        {
          opacity: 1,
          y: 0,
          scale: 1,
          duration: 1,
          scrollTrigger: { trigger: imageRef.current, start: "top 85%" },
        },
      )
    }, sectionRef)

    return () => ctx.revert()
  }, [])

  return (
    <section ref={sectionRef} id="fasilitas" className="py-24 md:py-32 bg-white relative overflow-hidden">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div ref={titleRef} className="text-center mb-16">
          <span className="inline-block px-4 py-2 bg-primary/10 text-primary text-sm font-semibold rounded-full mb-4">
            Fasilitas Lengkap
          </span>
          <h2 className="text-4xl md:text-5xl font-bold text-foreground mb-6">Keunggulan & Fasilitas</h2>
          <p className="text-muted-foreground text-lg max-w-2xl mx-auto">
            Fasilitas sekolah yang lengkap dan memadai untuk mendukung kegiatan belajar mengajar.
          </p>
        </div>

        <div className="grid lg:grid-cols-2 gap-12 items-start">
          <div ref={leftRef}>
            <h3 className="text-xl font-bold text-foreground mb-8 flex items-center gap-3">
              <div className="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                <CheckCircle className="w-5 h-5 text-primary" />
              </div>
              Mengapa Memilih Kami?
            </h3>
            <div className="grid sm:grid-cols-2 gap-4">
              {advantages.map((item, index) => (
                <div
                  key={index}
                  className="p-6 bg-secondary/50 rounded-2xl hover:bg-secondary hover:shadow-lg transition-all duration-300 group cursor-default"
                >
                  <div className="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-primary transition-all duration-300">
                    <item.icon className="w-6 h-6 text-primary group-hover:text-primary-foreground transition-colors" />
                  </div>
                  <h4 className="font-bold text-foreground mb-2">{item.title}</h4>
                  <p className="text-sm text-muted-foreground">{item.description}</p>
                </div>
              ))}
            </div>
          </div>

          <div ref={rightRef}>
            <h3 className="text-xl font-bold text-foreground mb-8 flex items-center gap-3">
              <div className="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                <Building className="w-5 h-5 text-primary" />
              </div>
              Fasilitas Sekolah
            </h3>
            <div className="grid sm:grid-cols-2 gap-3">
              {facilities.map((facility, index) => (
                <div
                  key={index}
                  className="flex items-start gap-3 p-4 bg-accent/30 rounded-2xl hover:bg-accent hover:shadow-lg transition-all duration-300 group"
                >
                  <div className="w-10 h-10 bg-white rounded-xl flex items-center justify-center shrink-0 shadow-sm group-hover:shadow-md group-hover:scale-110 transition-all duration-300">
                    <facility.icon className="w-5 h-5 text-primary" />
                  </div>
                  <div>
                    <h4 className="font-bold text-foreground text-sm">{facility.name}</h4>
                    <p className="text-xs text-muted-foreground">{facility.description}</p>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>

        <div ref={imageRef} className="mt-16 relative rounded-3xl overflow-hidden group">
          <img
            src="/modern-indonesian-school-computer-laboratory-with-.jpg"
            alt="Fasilitas SMK Diponegoro Karanganyar"
            className="w-full h-72 md:h-96 object-cover group-hover:scale-105 transition-transform duration-700"
          />
          <div className="absolute inset-0 bg-gradient-to-t from-foreground/80 via-foreground/20 to-transparent" />
          <div className="absolute bottom-0 left-0 right-0 p-8">
            <p className="text-white font-bold text-2xl mb-2">Laboratorium Komputer Modern</p>
            <p className="text-white/80">Dilengkapi perangkat terbaru untuk mendukung pembelajaran praktik</p>
          </div>
        </div>
      </div>
    </section>
  )
}

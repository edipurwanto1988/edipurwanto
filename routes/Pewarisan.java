/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.pewarisan;
/**
 *
 * @author macbook
 */

// Superclass
class Karyawan {
    String nama;

    public Karyawan(String nama) {
        this.nama = nama;
    }

    public double hitungGaji() {
        return 0; // akan dioverride di subclass
    }
}

// Subclass 1
class KaryawanTetap extends Karyawan {
    double gajiPokok;
    double tunjangan;

    public KaryawanTetap(String nama, double gajiPokok, double tunjangan) {
        super(nama);
        this.gajiPokok = gajiPokok;
        this.tunjangan = tunjangan;
    }

    @Override
    public double hitungGaji() {
        return gajiPokok + tunjangan;
    }
}

// Subclass 2
class KaryawanHonorer extends Karyawan {
    double jamKerja;
    double upahPerJam;

    public KaryawanHonorer(String nama, double jamKerja, double upahPerJam) {
        super(nama);
        this.jamKerja = jamKerja;
        this.upahPerJam = upahPerJam;
    }

    @Override
    public double hitungGaji() {
        return jamKerja * upahPerJam;
    }
}

// Main class (hanya ini yang public)
public class Pewarisan {
    public static void main(String[] args) {
        KaryawanTetap tetap = new KaryawanTetap("Budi", 5x_000_000, 1_000_000);
        KaryawanHonorer honorer = new KaryawanHonorer("Ani", 120, 50_000);

        System.out.println("Gaji " + tetap.nama + ": Rp" + tetap.hitungGaji());
        System.out.println("Gaji " + honorer.nama + ": Rp" + honorer.hitungGaji());
    }
}


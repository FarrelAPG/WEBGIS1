"""Filter VIIRS hotspot CSV records to Palembang and export Leaflet-ready JSON.

Usage:
    python merge_hotspots.py VIIRS.csv
"""

import argparse
from pathlib import Path

import pandas as pd


REQUIRED_COLUMNS = {"latitude", "longitude", "acq_date"}
MIN_LATITUDE = -3.10
MAX_LATITUDE = -2.85
MIN_LONGITUDE = 104.60
MAX_LONGITUDE = 104.90


def load_hotspots(path: Path) -> pd.DataFrame:
    if not path.is_file():
        raise FileNotFoundError(f"Dataset tidak ditemukan: {path}")

    hotspots = pd.read_csv(path)
    missing_columns = REQUIRED_COLUMNS.difference(hotspots.columns)

    if missing_columns:
        missing = ", ".join(sorted(missing_columns))
        raise ValueError(f"Kolom wajib tidak ditemukan di {path}: {missing}")

    return hotspots


def main() -> None:
    parser = argparse.ArgumentParser(
        description="Filter data hotspot VIIRS untuk peta Palembang."
    )
    parser.add_argument("viirs_csv", type=Path, help="CSV VIIRS Indonesia")
    parser.add_argument(
        "-o",
        "--output",
        type=Path,
        default=Path("hotspot_palembang_clean.json"),
        help="Path JSON keluaran (default: hotspot_palembang_clean.json)",
    )
    args = parser.parse_args()

    viirs = load_hotspots(args.viirs_csv)
    viirs["latitude"] = pd.to_numeric(viirs["latitude"], errors="coerce")
    viirs["longitude"] = pd.to_numeric(viirs["longitude"], errors="coerce")
    viirs_palembang = viirs.loc[
        viirs["latitude"].between(MIN_LATITUDE, MAX_LATITUDE, inclusive="both")
        & viirs["longitude"].between(MIN_LONGITUDE, MAX_LONGITUDE, inclusive="both")
    ].copy()

    viirs_palembang["latitude_rounded"] = viirs_palembang["latitude"].round(2)
    viirs_palembang["longitude_rounded"] = viirs_palembang["longitude"].round(
        2
    )
    clean = (
        viirs_palembang.drop_duplicates(
            subset=["latitude_rounded", "longitude_rounded", "acq_date"],
            keep="first",
        )
        .drop(columns=["latitude_rounded", "longitude_rounded"])
    )

    args.output.parent.mkdir(parents=True, exist_ok=True)
    clean.to_json(args.output, orient="records", indent=2, force_ascii=False)
    print(
        f"JSON tersimpan di {args.output} "
        f"({len(clean)} hotspot VIIRS; "
        f"{len(viirs_palembang) - len(clean)} duplikat dihapus)."
    )


if __name__ == "__main__":
    main()

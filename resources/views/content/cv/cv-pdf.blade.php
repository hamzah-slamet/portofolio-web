<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: sans-serif; color: #1e293b; font-size: 11px; line-height: 1.5; }

    .header { background: #1e3a5f; color: #fff; padding: 22px 26px; }
    .header table { width: 100%; }
    .photo { width: 74px; height: 74px; border-radius: 8px; object-fit: cover; }
    .photo-ph {
        width: 74px; height: 74px; border-radius: 8px; background: #33507a;
        text-align: center; color: #fff; font-size: 30px; font-weight: bold;
        line-height: 74px;
    }
    .name { font-size: 22px; font-weight: bold; }
    .title { font-size: 12px; color: #93c5fd; margin-top: 2px; }
    .contacts { margin-top: 8px; font-size: 10px; color: #cbd5e1; }
    .contacts span { margin-right: 14px; }

    .body { width: 100%; }
    .col-left { width: 33%; background: #f1f5f9; padding: 18px 16px; vertical-align: top; }
    .col-right { width: 67%; padding: 18px 20px; vertical-align: top; }

    .sec { margin-bottom: 16px; }
    .sec-title {
        font-size: 10px; font-weight: bold; text-transform: uppercase;
        letter-spacing: 1px; color: #2563eb; border-bottom: 2px solid #bfdbfe;
        padding-bottom: 4px; margin-bottom: 8px;
    }

    .info-lbl { font-size: 8.5px; text-transform: uppercase; color: #94a3b8; font-weight: bold; }
    .info-val { font-size: 10.5px; font-weight: bold; margin-bottom: 7px; }

    .skill { margin-bottom: 7px; }
    .skill-top { font-size: 10px; font-weight: bold; color: #334155; }
    .skill-pct { color: #2563eb; float: right; }
    .bar { height: 5px; background: #e2e8f0; border-radius: 3px; margin-top: 3px; }
    .bar-fill { height: 5px; background: #2563eb; border-radius: 3px; }

    .entry { margin-bottom: 12px; padding-left: 10px; border-left: 2px solid #e2e8f0; }
    .entry-title { font-size: 11.5px; font-weight: bold; color: #0f172a; }
    .entry-sub { font-size: 10px; font-weight: bold; color: #2563eb; }
    .entry-period { font-size: 9px; color: #94a3b8; margin: 1px 0 3px; }
    .entry-desc { font-size: 10px; color: #475569; }

    .tag {
        display: inline-block; font-size: 8.5px; font-weight: bold; padding: 1px 6px;
        background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;
        border-radius: 3px; margin: 3px 3px 0 0;
    }
    .proj { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px 10px; margin-bottom: 8px; }
    .muted { font-size: 10px; color: #94a3b8; }
</style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <table>
            <tr>
                <td style="width:86px; vertical-align:middle;">
                    @if($user->foto_profil)
                        <img src="{{ public_path('storage/' . $user->foto_profil) }}" class="photo">
                    @else
                        <div class="photo-ph">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    @endif
                </td>
                <td style="vertical-align:middle;">
                    <div class="name">{{ $user->name }}</div>
                    <div class="title">{{ $config->profile_position ?? 'Web Developer' }}</div>
                    <div class="contacts">
                        <span>Email: {{ $user->email }}</span>
                        @if($user->umur)<span>{{ $user->umur }} tahun</span>@endif
                        @if($user->alamat)<span>{{ $user->alamat }}</span>@endif
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Body 2 kolom (tabel agar DomPDF rapi) --}}
    <table class="body">
        <tr>
            {{-- Kolom kiri --}}
            <td class="col-left">

                <div class="sec">
                    <div class="sec-title">Info Pribadi</div>
                    <div class="info-lbl">Tempat, Tgl Lahir</div>
                    <div class="info-val">
                        @if($user->tempat_lahir || $user->tanggal_lahir)
                            {{ $user->tempat_lahir }}{{ $user->tempat_lahir && $user->tanggal_lahir ? ', ' : '' }}{{ optional($user->tanggal_lahir)->format('d M Y') }}
                        @else — @endif
                    </div>
                    <div class="info-lbl">Jenis Kelamin</div>
                    <div class="info-val">{{ $user->jenis_kelamin ?? '—' }}</div>
                    <div class="info-lbl">Agama</div>
                    <div class="info-val">{{ $user->agama ?? '—' }}</div>
                    <div class="info-lbl">Status</div>
                    <div class="info-val">{{ $user->status_pernikahan ?? '—' }}</div>
                    <div class="info-lbl">Kewarganegaraan</div>
                    <div class="info-val">{{ $user->kewarganegaraan ?? '—' }}</div>
                </div>

                <div class="sec">
                    <div class="sec-title">Keahlian</div>
                    @forelse($skills as $skill)
                        <div class="skill">
                            <div class="skill-top">{{ $skill->name }} <span class="skill-pct">{{ $skill->level }}%</span></div>
                            <div class="bar"><div class="bar-fill" style="width:{{ min(100, (int) $skill->level) }}%;"></div></div>
                        </div>
                    @empty
                        <div class="muted">Belum ada data keahlian.</div>
                    @endforelse
                </div>

            </td>

            {{-- Kolom kanan --}}
            <td class="col-right">

                <div class="sec">
                    <div class="sec-title">Tentang Saya</div>
                    <div class="entry-desc">{{ $user->tentang ?: 'Belum ada deskripsi.' }}</div>
                </div>

                <div class="sec">
                    <div class="sec-title">Pengalaman Kerja</div>
                    @forelse($experiences as $exp)
                        <div class="entry">
                            <div class="entry-title">{{ $exp->position }}</div>
                            <div class="entry-sub">{{ $exp->company }}</div>
                            <div class="entry-period">
                                {{ optional($exp->start_date)->format('M Y') }} –
                                {{ $exp->is_current ? 'Sekarang' : optional($exp->end_date)->format('M Y') }}
                                @if($exp->location) · {{ $exp->location }} @endif
                            </div>
                            @if($exp->description)<div class="entry-desc">{{ $exp->description }}</div>@endif
                        </div>
                    @empty
                        <div class="muted">Belum ada data pengalaman.</div>
                    @endforelse
                </div>

                <div class="sec">
                    <div class="sec-title">Pendidikan</div>
                    @forelse($educations as $edu)
                        <div class="entry">
                            <div class="entry-title">{{ $edu->degree }}@if($edu->major) — {{ $edu->major }}@endif</div>
                            <div class="entry-sub">{{ $edu->institution }}</div>
                            <div class="entry-period">
                                {{ optional($edu->start_date)->format('Y') }} –
                                {{ $edu->is_current ? 'Sekarang' : optional($edu->end_date)->format('Y') }}
                                @if($edu->gpa) · IPK {{ $edu->gpa }} @endif
                            </div>
                            @if($edu->description)<div class="entry-desc">{{ $edu->description }}</div>@endif
                        </div>
                    @empty
                        <div class="muted">Belum ada data pendidikan.</div>
                    @endforelse
                </div>

                <div class="sec">
                    <div class="sec-title">Proyek Unggulan</div>
                    @forelse($projects as $project)
                        <div class="proj">
                            <div class="entry-title">{{ $project->title }}</div>
                            <div class="entry-desc">{{ $project->description }}</div>
                            @if(!empty($project->tech_stack) && is_array($project->tech_stack))
                                <div>@foreach($project->tech_stack as $tag)<span class="tag">{{ $tag }}</span>@endforeach</div>
                            @endif
                        </div>
                    @empty
                        <div class="muted">Belum ada data proyek.</div>
                    @endforelse
                </div>

            </td>
        </tr>
    </table>

</body>
</html>

import 'package:flutter/material.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;

// ============================================================
// CONFIG
// ============================================================
const String BASE_URL = 'http://127.0.0.1:8000/api/v1';

const Color kPrimary = Color(0xFF4F46E5);
const Color kPrimaryDark = Color(0xFF3730A3);
const Color kBg = Color(0xFFF1F5F9);
const Color kTextMain = Color(0xFF0F172A);
const Color kTextSub = Color(0xFF64748B);
const Color kGreen = Color(0xFF16A34A);
const Color kOrange = Color(0xFFEA580C);
const Color kBlue = Color(0xFF2563EB);
const Color kPurple = Color(0xFF7C3AED);

void main() => runApp(const GSBApp());

// ============================================================
// MODÈLES
// ============================================================

class Praticien {
  final int id;
  final String nom, prenom, type;
  final double noteExpert, noteClient, noteGlobale;

  Praticien(
      {required this.id,
      required this.nom,
      required this.prenom,
      required this.type,
      required this.noteExpert,
      required this.noteClient,
      required this.noteGlobale});

  factory Praticien.fromJson(Map<String, dynamic> j) => Praticien(
        id: j['id'],
        nom: j['nom'],
        prenom: j['prenom'],
        type: j['type'] ?? '',
        noteExpert: (j['note_expert'] ?? 0).toDouble(),
        noteClient: (j['note_client'] ?? 0).toDouble(),
        noteGlobale: (j['note_globale'] ?? 0).toDouble(),
      );

  String get nomComplet => '$prenom $nom';
  bool get hasNotes => noteGlobale > 0;
}

class Evaluation {
  final double note;
  final String commentaire, date;
  Evaluation(
      {required this.note, required this.commentaire, required this.date});
  factory Evaluation.fromJson(Map<String, dynamic> j) => Evaluation(
        note: (j['note'] ?? 0).toDouble(),
        commentaire: j['commentaire'] ?? '',
        date: j['date'] ?? '',
      );
}

class PraticienDetail {
  final int id;
  final String nom, prenom, adresse, ville, codePostal, type;
  final double noteExpert, noteClient;
  final List<Evaluation> evaluationsExpert, evaluationsClient;

  PraticienDetail(
      {required this.id,
      required this.nom,
      required this.prenom,
      required this.adresse,
      required this.ville,
      required this.codePostal,
      required this.type,
      required this.noteExpert,
      required this.noteClient,
      required this.evaluationsExpert,
      required this.evaluationsClient});

  String get nomComplet => '$prenom $nom';

  factory PraticienDetail.fromJson(Map<String, dynamic> j) => PraticienDetail(
        id: j['id'],
        nom: j['nom'],
        prenom: j['prenom'],
        adresse: j['adresse'] ?? '',
        ville: j['ville'] ?? '',
        codePostal: j['code_postal'] ?? '',
        type: j['type'] ?? '',
        noteExpert: (j['note_expert'] ?? 0).toDouble(),
        noteClient: (j['note_client'] ?? 0).toDouble(),
        evaluationsExpert: (j['evaluations_expert'] as List)
            .map((e) => Evaluation.fromJson(e))
            .toList(),
        evaluationsClient: (j['evaluations_client'] as List)
            .map((e) => Evaluation.fromJson(e))
            .toList(),
      );
}

// ============================================================
// API
// ============================================================

class ApiService {
  static Future<List<Praticien>> getPraticiens({String sort = 'nom'}) async {
    final res = await http.get(Uri.parse('$BASE_URL/praticiens?sort=$sort'),
        headers: {'Accept': 'application/json'});
    if (res.statusCode == 200) {
      final data = jsonDecode(res.body);
      return (data['data'] as List).map((e) => Praticien.fromJson(e)).toList();
    }
    throw Exception('Erreur serveur (${res.statusCode})');
  }

  static Future<PraticienDetail> getDetail(int id) async {
    final res = await http.get(Uri.parse('$BASE_URL/praticiens/$id'),
        headers: {'Accept': 'application/json'});
    if (res.statusCode == 200) {
      return PraticienDetail.fromJson(jsonDecode(res.body)['data']);
    }
    throw Exception('Erreur serveur (${res.statusCode})');
  }
}

// ============================================================
// APP
// ============================================================

class GSBApp extends StatelessWidget {
  const GSBApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'GSB Praticiens',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        colorScheme:
            ColorScheme.fromSeed(seedColor: kPrimary, primary: kPrimary),
        useMaterial3: true,
        scaffoldBackgroundColor: kBg,
        cardTheme: CardThemeData(
          elevation: 0,
          color: Colors.white,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
            side: BorderSide(color: Colors.grey.shade200),
          ),
        ),
      ),
      home: const ListePage(),
    );
  }
}

// ============================================================
// PAGE LISTE
// ============================================================

class ListePage extends StatefulWidget {
  const ListePage({super.key});
  @override
  State<ListePage> createState() => _ListePageState();
}

class _ListePageState extends State<ListePage> {
  List<Praticien> _praticiens = [];
  bool _loading = true;
  String _error = '';
  String _sort = 'nom';
  final _searchCtrl = TextEditingController();
  List<Praticien> _filtered = [];

  @override
  void initState() {
    super.initState();
    _load();
  }

  Future<void> _load() async {
    setState(() {
      _loading = true;
      _error = '';
    });
    try {
      final data = await ApiService.getPraticiens(sort: _sort);
      setState(() {
        _praticiens = data;
        _filtered = data;
        _loading = false;
      });
      // Ré-appliquer la recherche si besoin
      if (_searchCtrl.text.isNotEmpty) _search(_searchCtrl.text);
    } catch (e) {
      setState(() {
        _error = e.toString();
        _loading = false;
      });
    }
  }

  void _search(String q) {
    setState(() {
      _filtered = q.isEmpty
          ? _praticiens
          : _praticiens
              .where((p) =>
                  p.nomComplet.toLowerCase().contains(q.toLowerCase()) ||
                  p.type.toLowerCase().contains(q.toLowerCase()))
              .toList();
    });
  }

  Color _typeColor(String type) {
    if (type.contains('Hospitalier')) return kBlue;
    if (type.contains('Ville')) return kGreen;
    if (type.contains('Officine')) return kOrange;
    if (type.contains('santé')) return kPurple;
    return kPrimary;
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: kBg,
      body: Column(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          _buildHeader(),
          Expanded(
            child: _loading
                ? const Center(
                    child: CircularProgressIndicator(color: kPrimary))
                : _error.isNotEmpty
                    ? _buildError()
                    : _buildList(),
          ),
        ],
      ),
    );
  }

  // ── HEADER ──────────────────────────────────────────────
  Widget _buildHeader() {
    return Container(
      decoration: const BoxDecoration(
        gradient: LinearGradient(
          colors: [kPrimary, kPrimaryDark],
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
        ),
      ),
      child: SafeArea(
        bottom: false,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Barre logo + tri
            Padding(
              padding: const EdgeInsets.fromLTRB(16, 12, 16, 0),
              child: Row(
                children: [
                  Container(
                    padding: const EdgeInsets.all(7),
                    decoration: BoxDecoration(
                      color: Colors.white.withOpacity(0.2),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    child: const Icon(Icons.local_hospital,
                        color: Colors.white, size: 20),
                  ),
                  const SizedBox(width: 10),
                  const Text('GSB',
                      style: TextStyle(
                          color: Colors.white,
                          fontSize: 20,
                          fontWeight: FontWeight.w800,
                          letterSpacing: 0.5)),
                  const Spacer(),
                  _SortButton(
                      current: _sort,
                      onChanged: (v) {
                        setState(() => _sort = v);
                        _load();
                      }),
                ],
              ),
            ),
            // Titre + compteur
            Padding(
              padding: const EdgeInsets.fromLTRB(16, 14, 16, 0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text('Annuaire des Praticiens',
                      style: TextStyle(
                          color: Colors.white,
                          fontSize: 22,
                          fontWeight: FontWeight.bold,
                          height: 1.2)),
                  const SizedBox(height: 4),
                  Row(children: [
                    const Icon(Icons.people_outline,
                        color: Colors.white70, size: 14),
                    const SizedBox(width: 5),
                    Text('${_filtered.length} praticien(s) trouvé(s)',
                        style: const TextStyle(
                            color: Colors.white70, fontSize: 13)),
                  ]),
                ],
              ),
            ),
            // Barre de recherche
            Padding(
              padding: const EdgeInsets.fromLTRB(16, 14, 16, 16),
              child: TextField(
                controller: _searchCtrl,
                onChanged: _search,
                style: const TextStyle(color: kTextMain, fontSize: 14),
                decoration: InputDecoration(
                  hintText: 'Rechercher par nom ou type...',
                  hintStyle:
                      const TextStyle(color: Color(0xFF94A3B8), fontSize: 13),
                  prefixIcon:
                      const Icon(Icons.search, color: kPrimary, size: 20),
                  suffixIcon: _searchCtrl.text.isNotEmpty
                      ? IconButton(
                          icon: const Icon(Icons.close,
                              size: 18, color: kTextSub),
                          onPressed: () {
                            _searchCtrl.clear();
                            _search('');
                          })
                      : null,
                  filled: true,
                  fillColor: Colors.white,
                  contentPadding: const EdgeInsets.symmetric(vertical: 0),
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10),
                    borderSide: BorderSide.none,
                  ),
                  enabledBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10),
                    borderSide: BorderSide.none,
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // ── LISTE ────────────────────────────────────────────────
  Widget _buildList() {
    return RefreshIndicator(
      onRefresh: _load,
      color: kPrimary,
      child: ListView.separated(
        padding: const EdgeInsets.fromLTRB(14, 14, 14, 24),
        itemCount: _filtered.length,
        separatorBuilder: (_, __) => const SizedBox(height: 8),
        itemBuilder: (ctx, i) {
          final p = _filtered[i];
          return _PraticienTile(
            praticien: p,
            typeColor: _typeColor(p.type),
            onTap: () => Navigator.push(
                ctx,
                MaterialPageRoute(
                    builder: (_) => DetailPage(id: p.id, nom: p.nomComplet))),
          );
        },
      ),
    );
  }

  // ── ERREUR ───────────────────────────────────────────────
  Widget _buildError() {
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(32),
        child: Column(mainAxisAlignment: MainAxisAlignment.center, children: [
          Container(
            padding: const EdgeInsets.all(20),
            decoration: BoxDecoration(
                color: Colors.red.shade50, shape: BoxShape.circle),
            child: Icon(Icons.wifi_off, size: 48, color: Colors.red.shade400),
          ),
          const SizedBox(height: 20),
          const Text('Impossible de charger les données',
              style: TextStyle(
                  fontSize: 17, fontWeight: FontWeight.bold, color: kTextMain),
              textAlign: TextAlign.center),
          const SizedBox(height: 8),
          Text('Vérifiez que Laravel tourne sur\n$BASE_URL',
              textAlign: TextAlign.center,
              style: const TextStyle(color: kTextSub, fontSize: 13)),
          const SizedBox(height: 24),
          ElevatedButton.icon(
            onPressed: _load,
            icon: const Icon(Icons.refresh, size: 18),
            label: const Text('Réessayer'),
            style: ElevatedButton.styleFrom(
              backgroundColor: kPrimary,
              foregroundColor: Colors.white,
              padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
              shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(10)),
            ),
          ),
        ]),
      ),
    );
  }
}

// ============================================================
// BOUTON DE TRI
// ============================================================

class _SortButton extends StatelessWidget {
  final String current;
  final ValueChanged<String> onChanged;
  const _SortButton({required this.current, required this.onChanged});

  String get _label {
    if (current == 'expert') return 'Note expert ↓';
    if (current == 'client') return 'Note client ↓';
    return 'Nom A→Z';
  }

  @override
  Widget build(BuildContext context) {
    return PopupMenuButton<String>(
      onSelected: onChanged,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 7),
        decoration: BoxDecoration(
          color: Colors.white.withOpacity(0.18),
          borderRadius: BorderRadius.circular(8),
          border: Border.all(color: Colors.white.withOpacity(0.3)),
        ),
        child: Row(children: [
          const Icon(Icons.sort, color: Colors.white, size: 16),
          const SizedBox(width: 6),
          Text(_label,
              style: const TextStyle(
                  color: Colors.white,
                  fontSize: 12,
                  fontWeight: FontWeight.w500)),
        ]),
      ),
      itemBuilder: (_) => [
        _item('nom', Icons.sort_by_alpha, 'Nom A→Z', current == 'nom'),
        _item('expert', Icons.verified_user, 'Meilleure note expert',
            current == 'expert'),
        _item('client', Icons.people, 'Meilleure note client',
            current == 'client'),
      ],
    );
  }

  PopupMenuItem<String> _item(
          String val, IconData icon, String label, bool selected) =>
      PopupMenuItem(
        value: val,
        child: Row(children: [
          Icon(icon, size: 18, color: selected ? kPrimary : kTextSub),
          const SizedBox(width: 10),
          Text(label,
              style: TextStyle(
                color: selected ? kPrimary : kTextMain,
                fontWeight: selected ? FontWeight.bold : FontWeight.normal,
                fontSize: 13,
              )),
          if (selected) ...[
            const Spacer(),
            const Icon(Icons.check, size: 15, color: kPrimary)
          ],
        ]),
      );
}

// ============================================================
// TUILE PRATICIEN
// ============================================================

class _PraticienTile extends StatelessWidget {
  final Praticien praticien;
  final Color typeColor;
  final VoidCallback onTap;
  const _PraticienTile(
      {required this.praticien, required this.typeColor, required this.onTap});

  @override
  Widget build(BuildContext context) {
    return Card(
      child: InkWell(
        onTap: onTap,
        borderRadius: BorderRadius.circular(12),
        child: Padding(
          padding: const EdgeInsets.all(13),
          child: Row(
            children: [
              // Avatar
              Container(
                width: 44,
                height: 44,
                decoration: BoxDecoration(
                  color: typeColor.withOpacity(0.1),
                  borderRadius: BorderRadius.circular(11),
                ),
                child: Icon(Icons.person, color: typeColor, size: 22),
              ),
              const SizedBox(width: 12),
              // Nom + type + notes
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(praticien.nomComplet,
                        style: const TextStyle(
                            fontWeight: FontWeight.w700,
                            fontSize: 14,
                            color: kTextMain)),
                    const SizedBox(height: 4),
                    // Badge type
                    Container(
                      padding: const EdgeInsets.symmetric(
                          horizontal: 8, vertical: 2),
                      decoration: BoxDecoration(
                        color: typeColor.withOpacity(0.1),
                        borderRadius: BorderRadius.circular(20),
                      ),
                      child: Text(praticien.type,
                          style: TextStyle(
                              fontSize: 11,
                              color: typeColor,
                              fontWeight: FontWeight.w600)),
                    ),
                    const SizedBox(height: 6),
                    // Notes inline
                    Row(children: [
                      _NoteChip(
                        icon: Icons.verified_user,
                        label: 'Expert',
                        note: praticien.noteExpert,
                        color: kOrange,
                      ),
                      const SizedBox(width: 10),
                      _NoteChip(
                        icon: Icons.people,
                        label: 'Client',
                        note: praticien.noteClient,
                        color: kBlue,
                      ),
                    ]),
                  ],
                ),
              ),
              const SizedBox(width: 8),
              // Droite : note globale + bouton
              Column(
                crossAxisAlignment: CrossAxisAlignment.end,
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  _GlobalBadge(note: praticien.noteGlobale),
                  const SizedBox(height: 10),
                  _Btn(onTap: onTap),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class _NoteChip extends StatelessWidget {
  final IconData icon;
  final String label;
  final double note;
  final Color color;
  const _NoteChip(
      {required this.icon,
      required this.label,
      required this.note,
      required this.color});

  @override
  Widget build(BuildContext context) {
    final hasNote = note > 0;
    return Row(children: [
      Icon(icon, size: 11, color: hasNote ? color : Colors.grey.shade400),
      const SizedBox(width: 3),
      Text(
        hasNote ? '$label: ${note.toStringAsFixed(1)}' : '$label: —',
        style: TextStyle(
            fontSize: 11,
            fontWeight: FontWeight.w600,
            color: hasNote ? color : Colors.grey.shade400),
      ),
    ]);
  }
}

class _GlobalBadge extends StatelessWidget {
  final double note;
  const _GlobalBadge({required this.note});

  @override
  Widget build(BuildContext context) {
    final has = note > 0;
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 9, vertical: 4),
      decoration: BoxDecoration(
        color: has ? kPrimary.withOpacity(0.1) : Colors.grey.shade100,
        borderRadius: BorderRadius.circular(20),
      ),
      child: Row(mainAxisSize: MainAxisSize.min, children: [
        Icon(has ? Icons.star_rounded : Icons.star_outline_rounded,
            size: 13, color: has ? kPrimary : Colors.grey.shade400),
        const SizedBox(width: 4),
        Text(
          has ? '${note.toStringAsFixed(1)}/5' : '—/5',
          style: TextStyle(
              fontSize: 12,
              fontWeight: FontWeight.bold,
              color: has ? kPrimary : Colors.grey.shade400),
        ),
      ]),
    );
  }
}

class _Btn extends StatelessWidget {
  final VoidCallback onTap;
  const _Btn({required this.onTap});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 13, vertical: 7),
        decoration: BoxDecoration(
          color: kPrimary,
          borderRadius: BorderRadius.circular(8),
          boxShadow: [
            BoxShadow(
                color: kPrimary.withOpacity(0.35),
                blurRadius: 8,
                offset: const Offset(0, 3))
          ],
        ),
        child: const Row(mainAxisSize: MainAxisSize.min, children: [
          Icon(Icons.visibility_outlined, color: Colors.white, size: 13),
          SizedBox(width: 5),
          Text('Détail',
              style: TextStyle(
                  color: Colors.white,
                  fontSize: 12,
                  fontWeight: FontWeight.w600)),
        ]),
      ),
    );
  }
}

// ============================================================
// PAGE DÉTAIL
// ============================================================

class DetailPage extends StatefulWidget {
  final int id;
  final String nom;
  const DetailPage({super.key, required this.id, required this.nom});

  @override
  State<DetailPage> createState() => _DetailPageState();
}

class _DetailPageState extends State<DetailPage>
    with SingleTickerProviderStateMixin {
  PraticienDetail? _detail;
  bool _loading = true;
  String _error = '';
  late TabController _tabs;

  @override
  void initState() {
    super.initState();
    _tabs = TabController(length: 2, vsync: this);
    _load();
  }

  @override
  void dispose() {
    _tabs.dispose();
    super.dispose();
  }

  Future<void> _load() async {
    setState(() {
      _loading = true;
      _error = '';
    });
    try {
      final d = await ApiService.getDetail(widget.id);
      setState(() {
        _detail = d;
        _loading = false;
      });
    } catch (e) {
      setState(() {
        _error = e.toString();
        _loading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: kBg,
      body: _loading
          ? const Center(child: CircularProgressIndicator(color: kPrimary))
          : _error.isNotEmpty
              ? _buildError()
              : _buildBody(),
    );
  }

  Widget _buildError() => Center(
          child: Padding(
        padding: const EdgeInsets.all(32),
        child: Column(mainAxisAlignment: MainAxisAlignment.center, children: [
          Icon(Icons.error_outline, size: 48, color: Colors.red.shade400),
          const SizedBox(height: 16),
          Text(_error,
              textAlign: TextAlign.center,
              style: const TextStyle(color: kTextSub)),
          const SizedBox(height: 16),
          ElevatedButton(
            onPressed: _load,
            child: const Text('Réessayer'),
            style: ElevatedButton.styleFrom(
                backgroundColor: kPrimary, foregroundColor: Colors.white),
          ),
        ]),
      ));

  Widget _buildBody() {
    final d = _detail!;
    return CustomScrollView(
      slivers: [
        // ── HEADER ──────────────────────────────────────
        SliverAppBar(
          expandedHeight: 160,
          pinned: true,
          backgroundColor: kPrimary,
          foregroundColor: Colors.white,
          elevation: 0,
          flexibleSpace: FlexibleSpaceBar(
            collapseMode: CollapseMode.pin,
            background: Container(
              decoration: const BoxDecoration(
                gradient: LinearGradient(
                  colors: [kPrimary, kPrimaryDark],
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                ),
              ),
              child: SafeArea(
                child: Padding(
                  padding: const EdgeInsets.fromLTRB(16, 48, 16, 16),
                  child: Row(children: [
                    Container(
                      width: 56,
                      height: 56,
                      decoration: BoxDecoration(
                        color: Colors.white.withOpacity(0.2),
                        borderRadius: BorderRadius.circular(16),
                      ),
                      child: const Icon(Icons.person,
                          color: Colors.white, size: 30),
                    ),
                    const SizedBox(width: 14),
                    Expanded(
                        child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Text(d.nomComplet,
                            style: const TextStyle(
                                color: Colors.white,
                                fontSize: 20,
                                fontWeight: FontWeight.bold,
                                height: 1.2)),
                        const SizedBox(height: 5),
                        Container(
                          padding: const EdgeInsets.symmetric(
                              horizontal: 10, vertical: 3),
                          decoration: BoxDecoration(
                            color: Colors.white.withOpacity(0.2),
                            borderRadius: BorderRadius.circular(20),
                          ),
                          child: Text(d.type,
                              style: const TextStyle(
                                  color: Colors.white, fontSize: 12)),
                        ),
                      ],
                    )),
                  ]),
                ),
              ),
            ),
          ),
        ),

        // ── CONTENU ─────────────────────────────────────
        SliverPadding(
          padding: const EdgeInsets.all(16),
          sliver: SliverList(
            delegate: SliverChildListDelegate([
              // Infos personnelles
              Card(
                child: Padding(
                  padding: const EdgeInsets.all(16),
                  child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        _SecTitle('Informations personnelles',
                            Icons.person_outline, kPrimary),
                        const SizedBox(height: 12),
                        _InfoRow(
                            Icons.location_on_outlined,
                            'Adresse',
                            d.adresse.isNotEmpty
                                ? d.adresse
                                : 'Non renseignée'),
                        const SizedBox(height: 10),
                        _InfoRow(
                            Icons.location_city_outlined,
                            'Ville',
                            [d.ville, d.codePostal]
                                .where((s) => s.isNotEmpty)
                                .join(' ')),
                      ]),
                ),
              ),
              const SizedBox(height: 12),

              // 2 cartes de score
              Row(children: [
                Expanded(
                    child: _ScoreCard(
                  label: 'Note Experts',
                  note: d.noteExpert,
                  count: d.evaluationsExpert.length,
                  color: kOrange,
                  icon: Icons.verified_user,
                )),
                const SizedBox(width: 12),
                Expanded(
                    child: _ScoreCard(
                  label: 'Note Clients',
                  note: d.noteClient,
                  count: d.evaluationsClient.length,
                  color: kBlue,
                  icon: Icons.people_outline,
                )),
              ]),
              const SizedBox(height: 16),

              // Onglets commentaires
              Card(
                child: Column(children: [
                  TabBar(
                    controller: _tabs,
                    labelColor: kPrimary,
                    unselectedLabelColor: kTextSub,
                    indicatorColor: kPrimary,
                    indicatorWeight: 3,
                    dividerColor: Colors.grey.shade200,
                    labelStyle: const TextStyle(
                        fontWeight: FontWeight.w700, fontSize: 13),
                    unselectedLabelStyle: const TextStyle(
                        fontWeight: FontWeight.normal, fontSize: 13),
                    tabs: [
                      Tab(text: 'Experts (${d.evaluationsExpert.length})'),
                      Tab(text: 'Clients (${d.evaluationsClient.length})'),
                    ],
                  ),
                  SizedBox(
                    height: 300,
                    child: TabBarView(
                      controller: _tabs,
                      children: [
                        _EvalList(
                            evaluations: d.evaluationsExpert, color: kOrange),
                        _EvalList(
                            evaluations: d.evaluationsClient, color: kBlue),
                      ],
                    ),
                  ),
                ]),
              ),

              const SizedBox(height: 16),
            ]),
          ),
        ),
      ],
    );
  }
}

// ============================================================
// WIDGETS PARTAGÉS
// ============================================================

class _SecTitle extends StatelessWidget {
  final String title;
  final IconData icon;
  final Color color;
  const _SecTitle(this.title, this.icon, this.color);

  @override
  Widget build(BuildContext context) => Row(children: [
        Icon(icon, size: 16, color: color),
        const SizedBox(width: 7),
        Text(title,
            style: TextStyle(
                fontSize: 13, fontWeight: FontWeight.bold, color: color)),
      ]);
}

class _InfoRow extends StatelessWidget {
  final IconData icon;
  final String label, value;
  const _InfoRow(this.icon, this.label, this.value);

  @override
  Widget build(BuildContext context) => Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Padding(
            padding: const EdgeInsets.only(top: 1),
            child: Icon(icon, size: 15, color: kTextSub),
          ),
          const SizedBox(width: 8),
          Expanded(
              child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                Text(label,
                    style: const TextStyle(fontSize: 11, color: kTextSub)),
                const SizedBox(height: 1),
                Text(value,
                    style: const TextStyle(
                        fontSize: 13,
                        color: kTextMain,
                        fontWeight: FontWeight.w600)),
              ])),
        ],
      );
}

class _ScoreCard extends StatelessWidget {
  final String label;
  final double note;
  final int count;
  final Color color;
  final IconData icon;
  const _ScoreCard(
      {required this.label,
      required this.note,
      required this.count,
      required this.color,
      required this.icon});

  @override
  Widget build(BuildContext context) {
    final has = note > 0;
    return Card(
      child: Padding(
        padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 12),
        child: Column(children: [
          Container(
            padding: const EdgeInsets.all(10),
            decoration: BoxDecoration(
              color: color.withOpacity(0.1),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(icon, color: color, size: 22),
          ),
          const SizedBox(height: 10),
          Text(label,
              style: const TextStyle(
                  fontSize: 11, color: kTextSub, fontWeight: FontWeight.w500),
              textAlign: TextAlign.center),
          const SizedBox(height: 6),
          Text(
            has ? '${note.toStringAsFixed(1)}/5' : '—',
            style: TextStyle(
                fontSize: 26,
                fontWeight: FontWeight.bold,
                color: has ? color : Colors.grey.shade400),
          ),
          const SizedBox(height: 4),
          Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: List.generate(
                  5,
                  (i) => Icon(
                        i < note.round()
                            ? Icons.star_rounded
                            : Icons.star_outline_rounded,
                        size: 15,
                        color: has ? color : Colors.grey.shade300,
                      ))),
          const SizedBox(height: 6),
          Text(
            count > 0 ? '$count avis' : 'Aucun avis',
            style: TextStyle(
                fontSize: 11,
                color: count > 0 ? kTextSub : Colors.grey.shade400),
          ),
        ]),
      ),
    );
  }
}

class _EvalList extends StatelessWidget {
  final List<Evaluation> evaluations;
  final Color color;
  const _EvalList({required this.evaluations, required this.color});

  @override
  Widget build(BuildContext context) {
    if (evaluations.isEmpty) {
      return Center(
          child: Column(mainAxisAlignment: MainAxisAlignment.center, children: [
        Icon(Icons.rate_review_outlined, size: 36, color: Colors.grey.shade300),
        const SizedBox(height: 8),
        Text('Aucune évaluation disponible',
            style: TextStyle(color: Colors.grey.shade400, fontSize: 13)),
      ]));
    }
    return ListView.separated(
      padding: const EdgeInsets.all(12),
      itemCount: evaluations.length,
      separatorBuilder: (_, __) => const SizedBox(height: 8),
      itemBuilder: (_, i) {
        final e = evaluations[i];
        return Container(
          padding: const EdgeInsets.all(12),
          decoration: BoxDecoration(
            color: color.withOpacity(0.04),
            borderRadius: BorderRadius.circular(10),
            border: Border.all(color: color.withOpacity(0.15)),
          ),
          child:
              Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
            Row(children: [
              // Étoiles
              ...List.generate(
                  5,
                  (s) => Icon(
                        s < e.note.round()
                            ? Icons.star_rounded
                            : Icons.star_outline_rounded,
                        size: 15,
                        color: color,
                      )),
              const SizedBox(width: 6),
              Text('${e.note}/5',
                  style: TextStyle(
                      fontSize: 12, fontWeight: FontWeight.bold, color: color)),
              const Spacer(),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 7, vertical: 2),
                decoration: BoxDecoration(
                  color: Colors.grey.shade100,
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Text(e.date,
                    style: const TextStyle(fontSize: 10, color: kTextSub)),
              ),
            ]),
            const SizedBox(height: 8),
            Text('"${e.commentaire}"',
                style: const TextStyle(
                    fontSize: 13,
                    color: kTextMain,
                    fontStyle: FontStyle.italic,
                    height: 1.4)),
          ]),
        );
      },
    );
  }
}
